<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Services\Pedido\PedidoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class PedidoController extends Controller
{
    public function __construct(protected PedidoService $service) {}

    public function index(): View
    {
        return view('pedido.index');
    }

    public function show(int $id): View
    {
        $pedido = $this->service->find($id);

        return view('pedido.show', compact('pedido'));
    }

    public function cancelar(Pedido $pedido): RedirectResponse
    {
        try {
            $this->service->cancelar($pedido);

            return redirect()->route('pedidos.show', $pedido->id)
                ->with('mensaje', 'Pedido cancelado correctamente.');
        } catch (ValidationException $e) {
            return redirect()->route('pedidos.show', $pedido->id)
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        $pedido = $this->service->find($id);

        if ($pedido->estado === Pedido::ESTADO_CONFIRMADO) {
            return redirect()->route('pedidos.index')
                ->with('error', 'No se puede eliminar un pedido confirmado.');
        }

        $pedido->delete();

        return redirect()->route('pedidos.index')
            ->with('mensaje', 'Pedido #'.$pedido->id.' eliminado correctamente.');
    }
}
