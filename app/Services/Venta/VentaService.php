<?php

namespace App\Services\Venta;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
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
        return $this
            ->applyFilters(Venta::query(), $filters)
            ->latest('fecha_venta')
            ->paginate(Venta::PAGINATION);
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return array{cantidad: int, total: float}
     */
    public function resumen(array $filters = []): array
    {
        $row = $this->applyFilters(Venta::query(), $filters)
            ->toBase()
            ->selectRaw('COUNT(*) as cantidad, COALESCE(SUM(total), 0) as total')
            ->first();

        return [
            'cantidad' => (int) ($row->cantidad ?? 0),
            'total' => round((float) ($row->total ?? 0), 2),
        ];
    }

    /**
     * @param  Builder<Venta>  $query
     * @param  array<string, mixed>  $filters
     * @return Builder<Venta>
     */
    private function applyFilters(Builder $query, array $filters): Builder
    {
        // 1. Búsqueda por ID o Relación (Optimizada)
        $query->when(filled($filters['search'] ?? null), function ($q) use ($filters) {
            $search = trim($filters['search']);

            $q->where(function ($sub) use ($search) {
                // Si el término es numérico, usa un 'where' exacto súper rápido por ID
                if (is_numeric($search)) {
                    $sub->where('id', (int) $search);
                }

                // Búsqueda en cliente por LIKE (usa sintaxis estándar de Eloquent)
                $sub->orWhereHas('cliente', function ($qClient) use ($search) {
                    $qClient->where('nombre', 'LIKE', '%' . addcslashes($search, '%_') . '%');
                });
            });
        });

        // 2. Filtros de igualdad simples (usando when)
        $query->when($filters['estado'] ?? null, fn($q, $estado) => $q->where('estado', $estado));
        $query->when($filters['metodo_pago'] ?? null, fn($q, $metodo) => $q->where('metodo_pago', $metodo));

        // 3. Rangos de Fecha (Optimizado para usar ÍNDICES)
        $query->when($filters['fecha_desde'] ?? null, fn($q, $desde) => $q->where('fecha_venta', '>=', $desde . ' 00:00:00'));
        $query->when($filters['fecha_hasta'] ?? null, fn($q, $hasta) => $q->where('fecha_venta', '<=', $hasta . ' 23:59:59'));

        return $query;
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
            $itemsMap = collect($items)->keyBy('producto_id');

            // 1. Cargar y BLOQUEAR todos los productos en 1 sola consulta
            $productos = Producto::whereIn('id', $itemsMap->keys())
                ->lockForUpdate()
                ->get();

            $detalles = [];
            $total = 0;

            foreach ($productos as $producto) {
                $cantidad = (int) $itemsMap[$producto->id]['cantidad'];

                // 2. Validación de stock en tiempo real
                if ($producto->stock < $cantidad) {
                    throw ValidationException::withMessages([
                        'items' => "Stock insuficiente para el producto {$producto->nombre}.",
                    ]);
                }

                $subtotal = round($producto->precio * $cantidad, 2);
                $total += $subtotal;

                // Preparamos los datos para inserción masiva
                $detalles[] = [
                    'producto_id'     => $producto->id,
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'subtotal'        => $subtotal,
                ];

                // 3. Descuento de stock directo en BD
                $producto->decrement('stock', $cantidad);
            }

            // 4. Crear la cabecera de la venta
            $venta = Venta::create([
                'cliente_id'  => $data['cliente_id'] ?? null,
                'usuario_id'  => auth()->id(),
                'fecha_venta' => $data['fecha_venta'] ?? now(),
                'total'       => round($total, 2),
                'metodo_pago' => $data['metodo_pago'],
                'estado'      => $data['estado'] ?? Venta::ESTADO_COMPLETADA,
            ]);

            // 5. Inserción masiva de detalles en 1 sola consulta
            $venta->detalleVentas()->createMany($detalles);

            return $venta;
        });
    }

    public function anular(Venta $venta): Venta
    {
        return DB::transaction(function () use ($venta) {
            // 1. Bloqueo pesimista sobre la venta para evitar peticiones concurrentes
            $venta = Venta::where('id', $venta->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($venta->estado === Venta::ESTADO_ANULADA) {
                throw ValidationException::withMessages([
                    'estado' => 'La venta ya se encuentra anulada.',
                ]);
            }

            // 2. Actualizar estado de la venta
            $venta->update([
                'estado' => Venta::ESTADO_ANULADA,
            ]);

            // 3. Cargar los detalles de la venta
            $detalles = $venta->detalleVentas()->get(['producto_id', 'cantidad']);

            // 4. Reponer stock masivamente directo en BD (Evita loop de N+1)
            foreach ($detalles as $detalle) {
                Producto::where('id', $detalle->producto_id)
                    ->increment('stock', $detalle->cantidad);
            }

            return $venta;
        });
    }
}
