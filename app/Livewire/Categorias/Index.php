<?php

namespace App\Livewire\Categorias;

use App\Services\Categoria\CategoriaService;
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
    public string $estado = '';

    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'estado'])) {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset('search', 'estado');

        $this->resetPage();
    }

    public function render(): View
    {
        $categorias = app(CategoriaService::class)->getAll([
            'search' => $this->search,
            'estado' => $this->estado,
        ]);

        return view('livewire.categorias.index', compact('categorias'));
    }
}
