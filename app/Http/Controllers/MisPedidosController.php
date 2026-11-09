<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\Pedido\PedidoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class MisPedidosController extends Controller
{
    public function __construct(protected PedidoService $service) {}

    public function index(Request $request): View
    {
        $pedidos = $this->service->getAllForCliente($request->user());

        return view('cuenta.pedidos.index', compact('pedidos'));
    }

    public function show(Request $request, Pedido $pedido): View
    {
        Gate::authorize('view', $pedido);

        $pedido->load(['detallePedidos.producto', 'venta']);

        return view('cuenta.pedidos.show', compact('pedido'));
    }

    public function cancelar(Request $request, Pedido $pedido): RedirectResponse
    {
        Gate::authorize('view', $pedido);

        try {
            $this->service->cancelar($pedido);
        } catch (ValidationException $e) {
            return redirect()->route('cliente.pedidos.show', $pedido)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('cliente.pedidos.show', $pedido)
            ->with('mensaje', 'Pedido cancelado correctamente.');
    }
}
