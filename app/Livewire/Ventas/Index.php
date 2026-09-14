<?php

namespace App\Livewire\Ventas;

use App\Models\Venta;
use App\Services\Venta\VentaService;
use Carbon\CarbonImmutable;
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
            if ($property === 'fecha_desde' && $this->fecha_desde !== '' && $this->fecha_hasta !== '' && $this->fecha_desde > $this->fecha_hasta) {
                $this->fecha_hasta = $this->fecha_desde;
            }

            if ($property === 'fecha_hasta' && $this->fecha_desde !== '' && $this->fecha_hasta !== '' && $this->fecha_desde > $this->fecha_hasta) {
                $this->fecha_desde = $this->fecha_hasta;
            }

            $this->resetPage();
        }
    }

    public function clearFilters(): void
    {
        $this->reset('search', 'estado', 'metodo_pago', 'fecha_desde', 'fecha_hasta');

        $this->resetPage();
    }

    public function resetOneFilter(string $field): void
    {
        if (property_exists($this, $field)) {
            $this->reset($field);
            $this->resetPage();
        }
    }

    public function applyDatePreset(string $preset): void
    {
        [$this->fecha_desde, $this->fecha_hasta] = $this->datePresetRange($preset);

        $this->resetPage();
    }

    /**
     * @return array{0: string, 1: string}
     */
    public function datePresetRange(string $preset): array
    {
        $today = CarbonImmutable::today();

        return match ($preset) {
            'hoy' => [$today->toDateString(), $today->toDateString()],
            '7dias' => [$today->subDays(6)->toDateString(), $today->toDateString()],
            'este_mes' => [$today->startOfMonth()->toDateString(), $today->endOfMonth()->toDateString()],
            'este_anio' => [$today->startOfYear()->toDateString(), $today->endOfYear()->toDateString()],
            default => ['', ''],
        };
    }

    public function hasActiveFilters(): bool
    {
        return $this->activeFiltersCount() > 0;
    }

    public function activeFiltersCount(): int
    {
        return collect([
            $this->search !== '',
            $this->estado !== '',
            $this->metodo_pago !== '',
            $this->fecha_desde !== '',
            $this->fecha_hasta !== '',
        ])->filter()->count();
    }

    public function render(): View
    {
        $filters = [
            'search' => $this->search,
            'estado' => $this->estado,
            'metodo_pago' => $this->metodo_pago,
            'fecha_desde' => $this->fecha_desde,
            'fecha_hasta' => $this->fecha_hasta,
        ];

        $ventas = app(VentaService::class)->getAll($filters);

        $resumen = app(VentaService::class)->resumen($filters);

        $estados = [
            Venta::ESTADO_COMPLETADA => 'Completada',
            Venta::ESTADO_ANULADA => 'Anulada',
        ];

        $metodosPago = [
            Venta::METODO_EFECTIVO => 'Efectivo',
            Venta::METODO_TARJETA => 'Tarjeta',
            Venta::METODO_TRANSFERENCIA => 'Transferencia',
        ];

        return view('livewire.ventas.index', compact('ventas', 'resumen', 'estados', 'metodosPago'));
    }
}
