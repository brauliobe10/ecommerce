<?php

namespace App\Livewire\Tienda;

use App\Models\Producto as ProductoModel;
use App\Services\Carrito\CarritoService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Producto extends Component
{
    public int $productoId = 0;

    public string $nombre = '';

    public string $codigo = '';

    public string $descripcion = '';

    public float $precio = 0;

    public int $stock = 0;

    public ?string $imagen = null;

    public int $cantidad = 1;

    public function mount(int $producto): void
    {
        $model = ProductoModel::findOrFail($producto);

        if (! $model->activo) {
            $this->redirectRoute('home', navigate: true);

            return;
        }

        $this->productoId = $model->id;
        $this->nombre = $model->nombre;
        $this->codigo = $model->codigo;
        $this->descripcion = (string) $model->descripcion;
        $this->precio = (float) $model->precio;
        $this->stock = (int) $model->stock;
        $this->imagen = $model->imagen;
    }

    public function addToCart(): void
    {
        try {
            app(CarritoService::class)->add($this->productoId, max($this->cantidad, 1));
        } catch (ValidationException $e) {
            session()->flash('error', $e->getMessage());

            return;
        }

        $this->dispatch('carrito-actualizado');
        $this->dispatch('abrir-carrito');

        session()->flash('mensaje', 'Producto agregado al carrito.');
    }

    public function render(): View
    {
        return view('livewire.tienda.producto');
    }
}
