<?php

namespace App\Livewire\Ventas;

use App\Models\Venta;
use App\Services\Venta\VentaService;
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

    #[Url(except: '')]
    public string $metodo_pago = '';

    #[Url(except: '')]
    public string $fecha_desde = '';

    #[Url(except: '')]
    public string $fecha_hasta = '';

    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'estado', 'metodo_pago', 'fecha_desde', 'fecha_hasta'])) {
            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset('search', 'estado', 'metodo_pago', 'fecha_desde', 'fecha_hasta');

        $this->resetPage();
    }

    public function render(): View
    {
        $ventas = app(VentaService::class)->getAll([
            'search' => $this->search,
            'estado' => $this->estado,
            'metodo_pago' => $this->metodo_pago,
            'fecha_desde' => $this->fecha_desde,
            'fecha_hasta' => $this->fecha_hasta,
        ]);

        $estados = [
            Venta::ESTADO_COMPLETADA => 'Completada',
            Venta::ESTADO_ANULADA => 'Anulada',
        ];

        $metodosPago = [
            Venta::METODO_EFECTIVO => 'Efectivo',
            Venta::METODO_TARJETA => 'Tarjeta',
            Venta::METODO_TRANSFERENCIA => 'Transferencia',
        ];

        return view('livewire.ventas.index', compact('ventas', 'estados', 'metodosPago'));
    }
}
