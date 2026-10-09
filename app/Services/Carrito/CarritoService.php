<?php

namespace App\Services\Carrito;

use App\Models\Producto;
use Illuminate\Validation\ValidationException;

class CarritoService
{
    private const SESSION_KEY = 'carrito';

    /**
     * @return array<int, array{producto_id: int, nombre: string, codigo: string, precio: float, cantidad: int, stock: int, imagen: string|null}>
     */
    public function all(): array
    {
        $items = session()->get(self::SESSION_KEY, []);

        return is_array($items) ? $items : [];
    }

    /**
     * @param  array<int, array{producto_id: int, nombre: string, codigo: string, precio: float, cantidad: int, stock: int, imagen: string|null}>  $items
     */
    private function persist(array $items): void
    {
        session()->put(self::SESSION_KEY, $items);
    }

    public function add(int $productoId, int $cantidad = 1): void
    {
        $cantidad = max($cantidad, 1);

        $producto = Producto::find($productoId);

        if (! $producto || ! $producto->activo) {
            throw ValidationException::withMessages([
                'carrito' => 'El producto no está disponible.',
            ]);
        }

        if ($producto->stock <= 0) {
            throw ValidationException::withMessages([
                'carrito' => "El producto {$producto->nombre} no tiene stock disponible.",
            ]);
        }

        $items = $this->all();
        $actual = $items[$productoId]['cantidad'] ?? 0;
        $nueva = min($actual + $cantidad, $producto->stock);

        $items[$productoId] = [
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
            'codigo' => $producto->codigo,
            'precio' => (float) $producto->precio,
            'cantidad' => $nueva,
            'stock' => (int) $producto->stock,
            'imagen' => $producto->imagen,
        ];

        $this->persist($items);
    }

    public function update(int $productoId, int $cantidad): void
    {
        $items = $this->all();

        if (! isset($items[$productoId])) {
            return;
        }

        if ($cantidad <= 0) {
            $this->remove($productoId);

            return;
        }

        $producto = Producto::find($productoId);

        if ($producto) {
            $cantidad = min($cantidad, max($producto->stock, 1));
            $items[$productoId]['stock'] = (int) $producto->stock;
        }

        $items[$productoId]['cantidad'] = $cantidad;

        $this->persist($items);
    }

    public function remove(int $productoId): void
    {
        $items = $this->all();

        unset($items[$productoId]);

        $this->persist($items);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function has(int $productoId): bool
    {
        return isset($this->all()[$productoId]);
    }

    public function count(): int
    {
        return array_sum(array_column($this->all(), 'cantidad'));
    }

    public function subtotal(): float
    {
        $total = 0;

        foreach ($this->all() as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return round($total, 2);
    }

    /**
     * @return array<int, array{producto_id: int, cantidad: int}>
     */
    public function toItems(): array
    {
        return array_values(array_map(
            fn (array $item) => [
                'producto_id' => (int) $item['producto_id'],
                'cantidad' => (int) $item['cantidad'],
            ],
            $this->all()
        ));
    }
}
