<?php

namespace App\Livewire\Tienda;

use App\Models\Categoria;
use App\Services\Carrito\CarritoService;
use App\Services\Producto\ProductoService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Catalogo extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $categoria = '';

    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'categoria'])) {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset('search', 'categoria');

        $this->resetPage();
    }

    public function addToCart(int $productoId): void
    {
        try {
            app(CarritoService::class)->add($productoId);
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
        $productos = app(ProductoService::class)->getAll([
            'search' => $this->search,
            'categoria' => $this->categoria,
            'activo' => true,
        ]);

        $categorias = Categoria::orderBy('nombre')->get();

        return view('livewire.tienda.catalogo', compact('productos', 'categorias'));
    }
}
