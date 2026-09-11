<?php

namespace App\Livewire\Productos;

use App\Models\Categoria;
use App\Services\Producto\ProductoService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
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

    public function render(): View
    {
        $productos = app(ProductoService::class)->getAll([
            'search' => $this->search,
            'categoria' => $this->categoria,
        ]);

        $categorias = Categoria::orderBy('nombre')->get();

        return view('livewire.productos.index', compact('productos', 'categorias'));
    }
}
