<?php

namespace App\Http\Controllers;

use App\Services\Dashboard\DashboardService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service) {}

    public function index(Request $request): View
    {
        $meses = $request->integer('meses', 12);
        $meses = in_array($meses, [6, 12], true) ? $meses : 12;

        return view('dashboard', [
            'resumen' => $this->service->resumen(),
            'ingresos' => $this->service->ingresosMensuales($meses),
            'pedidos' => $this->service->pedidosMensuales($meses),
            'metodosPago' => $this->service->ingresosPorMetodoPago($meses),
            'ultimasVentas' => $this->service->ultimasVentas(),
            'stockBajo' => $this->service->productosStockBajo(),
            'meses' => $meses,
        ]);
    }
}
