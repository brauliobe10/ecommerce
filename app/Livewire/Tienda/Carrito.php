<?php

namespace App\Livewire\Tienda;

use App\Services\Carrito\CarritoService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Carrito extends Component
{
    /** @var array<int, array{producto_id: int, nombre: string, codigo: string, precio: float, cantidad: int, imagen: string|null}> */
    public array $items = [];

    public function mount(): void
    {
        $this->items = app(CarritoService::class)->all();
    }

    #[On('carrito-actualizado')]
    public function refresh(): void
    {
        $this->items = app(CarritoService::class)->all();
    }

    public function increment(int $productoId): void
    {
        app(CarritoService::class)->add($productoId, 1);

        $this->afterChange();
    }

    public function decrement(int $productoId): void
    {
        $cantidad = (int) ($this->items[$productoId]['cantidad'] ?? 0);

        app(CarritoService::class)->update($productoId, $cantidad - 1);

        $this->afterChange();
    }

    public function remove(int $productoId): void
    {
        app(CarritoService::class)->remove($productoId);

        $this->afterChange();
    }

    public function clear(): void
    {
        app(CarritoService::class)->clear();

        $this->afterChange();
    }

    private function afterChange(): void
    {
        $this->refresh();

        $this->dispatch('carrito-actualizado');
    }

    public function getCantidadProperty(): int
    {
        return app(CarritoService::class)->count();
    }

    public function getSubtotalProperty(): float
    {
        return app(CarritoService::class)->subtotal();
    }

    public function render(): View
    {
        return view('livewire.tienda.carrito');
    }
}
