<?php

namespace App\Services\Pedido;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PedidoService
{
    /**
     * @param  array<string, mixed>  $filters
     * @return PaginationLengthAwarePaginator<int, Pedido>
     */
    public function getAll(array $filters = []): PaginationLengthAwarePaginator
    {
        return $this->applyFilters(Pedido::query()->withCount('detallePedidos'), $filters)
            ->latest()
            ->paginate(Pedido::PAGINATION);
    }

    /**
     * @return PaginationLengthAwarePaginator<int, Pedido>
     */
    public function getAllForCliente(User $user): PaginationLengthAwarePaginator
    {
        return $this->queryParaCliente($user)
            ->withCount('detallePedidos')
            ->latest()
            ->paginate(Pedido::PAGINATION);
    }

    /**
     * @return Collection<int, Pedido>
     */
    public function recientesParaCliente(User $user, int $limit = 5): Collection
    {
        return $this->queryParaCliente($user)
            ->withCount('detallePedidos')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * @return Builder<Pedido>
     */
    private function queryParaCliente(User $user): Builder
    {
        $clienteId = $user->cliente?->id;
        $email = mb_strtolower($user->email);

        return Pedido::query()->where(function (Builder $query) use ($clienteId, $email) {
            if ($clienteId !== null) {
                $query->where('cliente_id', $clienteId);
            }

            $query->orWhere(function (Builder $query) use ($email) {
                $query->whereNull('cliente_id')
                    ->whereRaw('LOWER(email) = ?', [$email]);
            });
        });
    }

    /**
     * @param  Builder<Pedido>  $query
     * @param  array<string, mixed>  $filters
     * @return Builder<Pedido>
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        $query->when(filled($filters['search'] ?? null), function ($q) use ($filters) {
            $search = trim((string) $filters['search']);
            $like = '%'.addcslashes($search, '%_').'%';

            $q->where(function ($sub) use ($search, $like) {
                if (is_numeric($search)) {
                    $sub->where('id', (int) $search);
                }

                $sub->orWhere('nombre_cliente', 'LIKE', $like)
                    ->orWhere('telefono', 'LIKE', $like);
            });
        });

        $query->when($filters['estado'] ?? null, fn ($q, $estado) => $q->where('estado', $estado));

        return $query;
    }

    public function find(int $id): Pedido
    {
        return Pedido::with(['cliente', 'venta', 'detallePedidos.producto'])
            ->findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array<string, mixed>>  $items
     */
    public function store(array $data, array $items): Pedido
    {
        return DB::transaction(function () use ($data, $items) {
            $itemsMap = collect($items)
                ->groupBy('producto_id')
                ->map(fn ($rows) => (int) collect($rows)->sum('cantidad'));

            /** @var Collection<int, Producto> $productos */
            $productos = Producto::whereIn('id', $itemsMap->keys())
                ->lockForUpdate()
                ->get();

            $detalles = [];
            $total = 0;

            foreach ($productos as $producto) {
                $cantidad = (int) $itemsMap->get($producto->id, 0);

                if ($cantidad < 1) {
                    continue;
                }

                if (! $producto->activo) {
                    throw ValidationException::withMessages([
                        'items' => "El producto {$producto->nombre} no está disponible.",
                    ]);
                }

                if ($producto->stock < $cantidad) {
                    throw ValidationException::withMessages([
                        'items' => "No hay stock suficiente para el producto {$producto->nombre}.",
                    ]);
                }

                $subtotal = round($producto->precio * $cantidad, 2);
                $total += $subtotal;

                $detalles[] = [
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal,
                ];
            }

            if ($detalles === []) {
                throw ValidationException::withMessages([
                    'items' => 'El pedido debe incluir al menos un producto válido.',
                ]);
            }

            $cliente = $this->resolverCliente($data);

            $pedido = Pedido::create([
                'cliente_id' => $cliente->id,
                'nombre_cliente' => $data['nombre'],
                'telefono' => $data['telefono'],
                'email' => filled($data['email'] ?? null) ? Str::lower(trim((string) $data['email'])) : null,
                'direccion' => $data['direccion'] ?? null,
                'notas' => $data['notas'] ?? null,
                'total' => round($total, 2),
                'estado' => Pedido::ESTADO_PENDIENTE,
            ]);

            $pedido->detallePedidos()->createMany($detalles);

            return $pedido;
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function resolverCliente(array $data): Cliente
    {
        $user = auth()->user();

        if ($user instanceof User && $user->isCliente() && $user->cliente !== null) {
            return $user->cliente;
        }

        $email = filled($data['email'] ?? null)
            ? Str::lower(trim((string) $data['email']))
            : ($user instanceof User && $user->isCliente() ? Str::lower($user->email) : null);
        $telefono = trim((string) ($data['telefono'] ?? ''));

        if ($email !== null) {
            $cliente = Cliente::query()
                ->whereRaw('LOWER(email) = ?', [$email])
                ->first();

            if ($cliente !== null) {
                return $cliente;
            }
        }

        $cliente = Cliente::create([
            'nombre' => $data['nombre'],
            'email' => $email,
            'telefono' => $telefono !== '' ? $telefono : null,
        ]);

        if ($user instanceof User && $user->isCliente()) {
            $cliente->update(['user_id' => $user->id]);
        }

        return $cliente;
    }

    public function confirmar(Pedido $pedido, Venta $venta): Pedido
    {
        return DB::transaction(function () use ($pedido, $venta) {
            $pedido = Pedido::where('id', $pedido->id)->lockForUpdate()->firstOrFail();

            if ($pedido->estado !== Pedido::ESTADO_PENDIENTE) {
                throw ValidationException::withMessages([
                    'estado' => 'El pedido ya no se encuentra pendiente.',
                ]);
            }

            $pedido->update([
                'venta_id' => $venta->id,
                'estado' => Pedido::ESTADO_CONFIRMADO,
            ]);

            return $pedido;
        });
    }

    public function cancelar(Pedido $pedido): Pedido
    {
        return DB::transaction(function () use ($pedido) {
            $pedido = Pedido::where('id', $pedido->id)->lockForUpdate()->firstOrFail();

            if ($pedido->estado !== Pedido::ESTADO_PENDIENTE) {
                throw ValidationException::withMessages([
                    'estado' => 'Solo se pueden cancelar pedidos pendientes.',
                ]);
            }

            $pedido->update([
                'estado' => Pedido::ESTADO_CANCELADO,
            ]);

            return $pedido;
        });
    }
}
