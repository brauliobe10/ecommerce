<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Services\Carrito\CarritoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TiendaController extends Controller
{
    public function __construct(protected CarritoService $carrito) {}

    public function index(): View
    {
        return view('tienda.index');
    }

    public function show(Producto $producto): View|RedirectResponse
    {
        if (! $producto->activo) {
            return redirect()->route('home');
        }

        return view('tienda.producto', compact('producto'));
    }

    public function checkout(): View|RedirectResponse
    {
        if ($this->carrito->count() === 0) {
            return redirect()->route('home')->with('error', 'Tu carrito está vacío.');
        }

        return view('tienda.checkout');
    }

    public function carrito(): View
    {
        return view('tienda.carrito');
    }

    public function sobreNosotros(): View
    {
        return view('tienda.sobre');
    }

    public function contacto(): View
    {
        return view('tienda.contacto');
    }
}
