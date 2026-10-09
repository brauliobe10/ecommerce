<?php

namespace App\Livewire\Tienda;

use App\Services\Carrito\CarritoService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CarritoBoton extends Component
{
    #[On('carrito-actualizado')]
    public function refresh(): void {}

    public function getCantidadProperty(): int
    {
        return app(CarritoService::class)->count();
    }

    public function render(): View
    {
        return view('livewire.tienda.carrito-boton');
    }
}
