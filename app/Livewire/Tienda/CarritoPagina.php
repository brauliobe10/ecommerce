<?php

namespace App\Livewire\Tienda;

use App\Livewire\Tienda\Concerns\GestionaCarrito;
use App\Services\Carrito\CarritoService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CarritoPagina extends Component
{
    use GestionaCarrito;

    public function render(): View
    {
        $this->items = app(CarritoService::class)->all();

        return view('livewire.tienda.carrito-pagina');
    }
}
