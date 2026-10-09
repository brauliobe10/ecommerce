<?php

namespace App\Livewire\Tienda;

use App\Http\Requests\Pedido\CreatePedidoRequest;
use App\Services\Carrito\CarritoService;
use App\Services\Pedido\PedidoService;
use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Checkout extends Component
{
    public string $nombre = '';

    public string $telefono = '';

    public string $email = '';

    public string $direccion = '';

    public string $notas = '';

    public function mount(): void
    {
        if (auth()->check()) {
            $this->nombre = (string) auth()->user()->name;
            $this->email = (string) auth()->user()->email;
        }
    }

    public function confirmar(): void
    {
        $this->validate((new CreatePedidoRequest)->rules());

        $carrito = app(CarritoService::class);

        if ($carrito->count() === 0) {
            $this->addError('items', 'Tu carrito está vacío.');

            return;
        }

        try {
            $pedido = app(PedidoService::class)->store([
                'nombre' => $this->nombre,
                'telefono' => $this->telefono,
                'email' => $this->email !== '' ? $this->email : null,
                'direccion' => $this->direccion !== '' ? $this->direccion : null,
                'notas' => $this->notas !== '' ? $this->notas : null,
            ], $carrito->toItems());
        } catch (ValidationException $e) {
            $this->addError('items', $e->getMessage());

            return;
        }

        $url = app(WhatsAppService::class)->urlPedido($pedido);

        $carrito->clear();

        $this->dispatch('carrito-actualizado');

        $this->redirect($url);
    }

    public function render(): View
    {
        $carrito = app(CarritoService::class);

        return view('livewire.tienda.checkout', [
            'items' => $carrito->all(),
            'total' => $carrito->subtotal(),
        ]);
    }
}
