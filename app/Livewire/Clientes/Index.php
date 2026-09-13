<?php

namespace App\Livewire\Clientes;

use App\Services\Cliente\ClienteService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    public function updated(string $property): void
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset('search');

        $this->resetPage();
    }

    public function render(): View
    {
        $clientes = app(ClienteService::class)->getAll([
            'search' => $this->search,
        ]);

        return view('livewire.clientes.index', compact('clientes'));
    }
}
