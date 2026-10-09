<?php

namespace App\Livewire\Pedidos;

use App\Models\Pedido;
use App\Services\Pedido\PedidoService;
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

    /** @var array<string, string> */
    public array $estados = [];

    public function mount(): void
    {
        $this->estados = [
            Pedido::ESTADO_PENDIENTE => 'Pendiente',
            Pedido::ESTADO_CONFIRMADO => 'Confirmado',
            Pedido::ESTADO_CANCELADO => 'Cancelado',
        ];
    }

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
        $pedidos = app(PedidoService::class)->getAll([
            'search' => $this->search,
            'estado' => $this->estado,
        ]);

        return view('livewire.pedidos.index', compact('pedidos'));
    }
}
