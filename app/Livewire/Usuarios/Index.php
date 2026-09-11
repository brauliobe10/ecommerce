<?php

namespace App\Livewire\Usuarios;

use App\Services\User\UserService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset('search');

        $this->resetPage();
    }

    public function render(): View
    {
        $usuarios = app(UserService::class)->getAll([
            'search' => $this->search,
        ]);

        return view('livewire.usuarios.index', compact('usuarios'));
    }
}
