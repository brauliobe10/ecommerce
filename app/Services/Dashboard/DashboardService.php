<?php

namespace App\Services\Dashboard;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Venta;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;

class DashboardService
{
    private const MESES = [
        'Ene',
        'Feb',
        'Mar',
        'Abr',
        'May',
        'Jun',
        'Jul',
        'Ago',
        'Sep',
        'Oct',
        'Nov',
        'Dic',
    ];

    private const METODOS_PAGO = [
        Venta::METODO_EFECTIVO => 'Efectivo',
        Venta::METODO_TARJETA => 'Tarjeta',
        Venta::METODO_TRANSFERENCIA => 'Transferencia',
    ];

    /**
     * @return array{
     *     ingresos: array{valor: float, variacion: array{porcentaje: float|null, direccion: 'up'|'down'|'flat'|'nuevo'}},
     *     ventas: array{valor: int, variacion: array{porcentaje: float|null, direccion: 'up'|'down'|'flat'|'nuevo'}},
     *     pedidos: array{pendientes: int, mes: int},
     *     clientes: array{total: int, nuevos: int, variacion: array{porcentaje: float|null, direccion: 'up'|'down'|'flat'|'nuevo'}}
     * }
     */
    public function resumen(): array
    {
        $inicioMes = CarbonImmutable::now()->startOfMonth();
        $finMes = CarbonImmutable::now()->endOfMonth();
        $inicioMesAnterior = $inicioMes->subMonth();
        $finMesAnterior = $inicioMes->subMonth()->endOfMonth();

        $ingresosMes = (float) Venta::query()
            ->where('estado', Venta::ESTADO_COMPLETADA)
            ->whereBetween('fecha_venta', [$inicioMes, $finMes])
            ->sum('total');

        $ingresosMesAnterior = (float) Venta::query()
            ->where('estado', Venta::ESTADO_COMPLETADA)
            ->whereBetween('fecha_venta', [$inicioMesAnterior, $finMesAnterior])
            ->sum('total');

        $ventasMes = Venta::query()
            ->where('estado', Venta::ESTADO_COMPLETADA)
            ->whereBetween('fecha_venta', [$inicioMes, $finMes])
            ->count();

        $ventasMesAnterior = Venta::query()
            ->where('estado', Venta::ESTADO_COMPLETADA)
            ->whereBetween('fecha_venta', [$inicioMesAnterior, $finMesAnterior])
            ->count();

        $pedidosPendientes = Pedido::query()
            ->where('estado', Pedido::ESTADO_PENDIENTE)
            ->count();

        $pedidosMes = Pedido::query()
            ->whereBetween('created_at', [$inicioMes, $finMes])
            ->count();

        $clientesTotal = Cliente::query()->count();

        $clientesNuevos = Cliente::query()
            ->whereBetween('created_at', [$inicioMes, $finMes])
            ->count();

        $clientesNuevosAnterior = Cliente::query()
            ->whereBetween('created_at', [$inicioMesAnterior, $finMesAnterior])
            ->count();

        return [
            'ingresos' => [
                'valor' => round($ingresosMes, 2),
                'variacion' => $this->variacion($ingresosMes, $ingresosMesAnterior),
            ],
            'ventas' => [
                'valor' => $ventasMes,
                'variacion' => $this->variacion((float) $ventasMes, (float) $ventasMesAnterior),
            ],
            'pedidos' => [
                'pendientes' => $pedidosPendientes,
                'mes' => $pedidosMes,
            ],
            'clientes' => [
                'total' => $clientesTotal,
                'nuevos' => $clientesNuevos,
                'variacion' => $this->variacion((float) $clientesNuevos, (float) $clientesNuevosAnterior),
            ],
        ];
    }

    /**
     * @return array{
     *     labels: list<string>,
     *     actual: list<float>,
     *     anterior: list<float>,
     *     total: float,
     *     total_anterior: float,
     *     variacion: array{porcentaje: float|null, direccion: 'up'|'down'|'flat'|'nuevo'},
     *     rango: string
     * }
     */
    public function ingresosMensuales(int $meses = 12): array
    {
        $fin = CarbonImmutable::now()->endOfMonth();
        $inicio = CarbonImmutable::now()->startOfMonth()->subMonths($meses - 1);
        $inicioComparacion = $inicio->subMonths($meses);

        $ventas = Venta::query()
            ->where('estado', Venta::ESTADO_COMPLETADA)
            ->whereBetween('fecha_venta', [$inicioComparacion, $fin])
            ->get(['fecha_venta', 'total']);

        /** @var array<string, float> $porMes */
        $porMes = [];

        foreach ($ventas as $venta) {
            $clave = $venta->fecha_venta->format('Y-m');
            $porMes[$clave] = ($porMes[$clave] ?? 0.0) + (float) $venta->total;
        }

        $labels = [];
        $actual = [];
        $anterior = [];
        $total = 0.0;
        $totalAnterior = 0.0;

        for ($i = 0; $i < $meses; $i++) {
            $mes = $inicio->addMonths($i);
            $clave = $mes->format('Y-m');
            $claveAnterior = $mes->subMonths($meses)->format('Y-m');

            $labels[] = self::MESES[(int) $mes->format('n') - 1];
            $actual[] = round($porMes[$clave] ?? 0.0, 2);
            $anterior[] = round($porMes[$claveAnterior] ?? 0.0, 2);

            $total += $porMes[$clave] ?? 0.0;
            $totalAnterior += $porMes[$claveAnterior] ?? 0.0;
        }

        return [
            'labels' => $labels,
            'actual' => $actual,
            'anterior' => $anterior,
            'total' => round($total, 2),
            'total_anterior' => round($totalAnterior, 2),
            'variacion' => $this->variacion($total, $totalAnterior),
            'rango' => $this->rango($inicio, $fin),
        ];
    }

    /**
     * @return array{
     *     labels: list<string>,
     *     valores: list<int>,
     *     total: int,
     *     total_anterior: int,
     *     variacion: array{porcentaje: float|null, direccion: 'up'|'down'|'flat'|'nuevo'},
     *     rango: string
     * }
     */
    public function pedidosMensuales(int $meses = 12): array
    {
        $fin = CarbonImmutable::now()->endOfMonth();
        $inicio = CarbonImmutable::now()->startOfMonth()->subMonths($meses - 1);
        $inicioComparacion = $inicio->subMonths($meses);

        $pedidos = Pedido::query()
            ->whereBetween('created_at', [$inicioComparacion, $fin])
            ->get(['created_at']);

        /** @var array<string, int> $porMes */
        $porMes = [];

        foreach ($pedidos as $pedido) {
            $clave = $pedido->created_at->format('Y-m');
            $porMes[$clave] = ($porMes[$clave] ?? 0) + 1;
        }

        $labels = [];
        $valores = [];
        $total = 0;
        $totalAnterior = 0;

        for ($i = 0; $i < $meses; $i++) {
            $mes = $inicio->addMonths($i);
            $clave = $mes->format('Y-m');
            $claveAnterior = $mes->subMonths($meses)->format('Y-m');

            $labels[] = self::MESES[(int) $mes->format('n') - 1];
            $valores[] = $porMes[$clave] ?? 0;

            $total += $porMes[$clave] ?? 0;
            $totalAnterior += $porMes[$claveAnterior] ?? 0;
        }

        return [
            'labels' => $labels,
            'valores' => $valores,
            'total' => $total,
            'total_anterior' => $totalAnterior,
            'variacion' => $this->variacion((float) $total, (float) $totalAnterior),
            'rango' => $this->rango($inicio, $fin),
        ];
    }

    /**
     * @return array{
     *     labels: list<string>,
     *     valores: list<float>,
     *     items: list<array{metodo: string, label: string, total: float, cantidad: int}>,
     *     total: float,
     *     rango: string
     * }
     */
    public function ingresosPorMetodoPago(int $meses = 12): array
    {
        $fin = CarbonImmutable::now()->endOfMonth();
        $inicio = CarbonImmutable::now()->startOfMonth()->subMonths($meses - 1);

        $ventas = Venta::query()
            ->where('estado', Venta::ESTADO_COMPLETADA)
            ->whereBetween('fecha_venta', [$inicio, $fin])
            ->get(['metodo_pago', 'total']);

        /** @var array<string, float> $totales */
        $totales = [];

        /** @var array<string, int> $cantidades */
        $cantidades = [];

        foreach ($ventas as $venta) {
            $metodo = (string) $venta->metodo_pago;
            $totales[$metodo] = ($totales[$metodo] ?? 0.0) + (float) $venta->total;
            $cantidades[$metodo] = ($cantidades[$metodo] ?? 0) + 1;
        }

        $labels = [];
        $valores = [];
        $items = [];
        $total = 0.0;

        foreach (self::METODOS_PAGO as $metodo => $label) {
            $monto = round($totales[$metodo] ?? 0.0, 2);
            $cantidad = $cantidades[$metodo] ?? 0;

            $labels[] = $label;
            $valores[] = $monto;
            $items[] = [
                'metodo' => $metodo,
                'label' => $label,
                'total' => $monto,
                'cantidad' => $cantidad,
            ];

            $total += $monto;
        }

        return [
            'labels' => $labels,
            'valores' => $valores,
            'items' => $items,
            'total' => round($total, 2),
            'rango' => $this->rango($inicio, $fin),
        ];
    }

    /**
     * @return Collection<int, Venta>
     */
    public function ultimasVentas(int $limite = 5): Collection
    {
        return Venta::query()
            ->with('cliente')
            ->latest('fecha_venta')
            ->limit($limite)
            ->get();
    }

    /**
     * @return Collection<int, Producto>
     */
    public function productosStockBajo(int $limite = 5): Collection
    {
        return Producto::query()
            ->where('activo', true)
            ->where('stock', '<=', Producto::STOCK_BAJO)
            ->orderBy('stock')
            ->orderBy('nombre')
            ->limit($limite)
            ->get();
    }

    /**
     * @return array{porcentaje: float|null, direccion: 'up'|'down'|'flat'|'nuevo'}
     */
    private function variacion(float $actual, float $anterior): array
    {
        if ($anterior == 0.0) {
            return [
                'porcentaje' => null,
                'direccion' => $actual > 0.0 ? 'nuevo' : 'flat',
            ];
        }

        $porcentaje = round((($actual - $anterior) / $anterior) * 100, 1);

        return [
            'porcentaje' => $porcentaje,
            'direccion' => $porcentaje > 0.0 ? 'up' : ($porcentaje < 0.0 ? 'down' : 'flat'),
        ];
    }

    private function rango(CarbonImmutable $inicio, CarbonImmutable $fin): string
    {
        return self::MESES[(int) $inicio->format('n') - 1].' '.$inicio->format('Y')
            .' – '.self::MESES[(int) $fin->format('n') - 1].' '.$fin->format('Y');
    }
}
