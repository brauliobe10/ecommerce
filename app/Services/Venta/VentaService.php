<?php

namespace App\Services\Venta;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VentaService
{
    /**
     * @param  array<string, mixed>  $filters
     * @return PaginationLengthAwarePaginator<int, Venta>
     */
    public function getAll(array $filters = []): PaginationLengthAwarePaginator
    {
        $query = Venta::query()->with(['cliente:id,nombre', 'usuario:id,name']);

        if (isset($filters['search']) && is_string($filters['search']) && $filters['search'] !== '') {
            $search = '%'.addcslashes(mb_strtolower(trim($filters['search'])), '%_').'%';
            $query->where(fn ($q) => $q
                ->whereHas('cliente', fn ($q) => $q->whereRaw('LOWER(nombre) LIKE ?', [$search]))
                ->orWhereRaw('CAST(id AS CHAR) LIKE ?', [$search]));
        }

        if (! empty($filters['estado'])) {
            $query->where('estado', $filters['estado']);
        }

        if (! empty($filters['metodo_pago'])) {
            $query->where('metodo_pago', $filters['metodo_pago']);
        }

        if (! empty($filters['fecha_desde'])) {
            $query->whereDate('fecha_venta', '>=', $filters['fecha_desde']);
        }

        if (! empty($filters['fecha_hasta'])) {
            $query->whereDate('fecha_venta', '<=', $filters['fecha_hasta']);
        }

        return $query->latest('fecha_venta')->paginate(Venta::PAGINATION);
    }

    public function find(int $id): Venta
    {
        return Venta::with(['cliente', 'usuario', 'detalleVentas.producto'])
            ->findOrFail($id);
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<int, array<string, mixed>>  $items
     */
    public function store(array $data, array $items): Venta
    {
        return DB::transaction(function () use ($data, $items) {
            $productos = collect($items)->map(function (array $item) {
                $producto = Producto::findOrFail((int) $item['producto_id']);
                $cantidad = (int) $item['cantidad'];

                if ($producto->stock < $cantidad) {
                    throw ValidationException::withMessages([
                        'items' => "Stock insuficiente para el producto {$producto->nombre}.",
                    ]);
                }

                return [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'subtotal' => round($producto->precio * $cantidad, 2),
                ];
            });

            $total = round($productos->sum('subtotal'), 2);

            $venta = Venta::create([
                'cliente_id' => $data['cliente_id'] ?? null,
                'usuario_id' => auth()->id(),
                'fecha_venta' => $data['fecha_venta'] ?? now(),
                'total' => $total,
                'metodo_pago' => $data['metodo_pago'],
                'estado' => $data['estado'] ?? Venta::ESTADO_COMPLETADA,
            ]);

            foreach ($productos as $item) {
                $venta->detalleVentas()->create([
                    'producto_id' => $item['producto']->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['producto']->precio,
                    'subtotal' => $item['subtotal'],
                ]);

                $item['producto']->decrement('stock', $item['cantidad']);
            }

            return $venta;
        });
    }

    public function anular(Venta $venta): Venta
    {
        return DB::transaction(function () use ($venta) {
            if ($venta->estado === Venta::ESTADO_ANULADA) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta ya se encuentra anulada.',
                ]);
            }

            $venta->estado = Venta::ESTADO_ANULADA;
            $venta->save();

            foreach ($venta->detalleVentas as $detalle) {
                $detalle->producto->increment('stock', $detalle->cantidad);
            }

            return $venta;
        });
    }
}
