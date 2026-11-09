<?php

namespace App\Http\Controllers;

use App\Services\Pedido\PedidoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $user->loadMissing('cliente');

        $pedidos = app(PedidoService::class)->recientesParaCliente($user);

        return view('cuenta.index', compact('user', 'pedidos'));
    }
}
