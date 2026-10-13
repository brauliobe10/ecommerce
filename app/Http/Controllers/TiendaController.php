<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Services\Carrito\CarritoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TiendaController extends Controller
{
    public function __construct(protected CarritoService $carrito) {}

    public function index(): View
    {
        $categoriasDestacadas = Categoria::query()
            ->where('estado', 'activo')
            ->whereHas('productos', fn ($q) => $q->where('productos.activo', true))
            ->withCount(['productos as cantidad_productos' => fn ($q) => $q->where('productos.activo', true)])
            ->orderByDesc('cantidad_productos')
            ->orderBy('nombre')
            ->limit(6)
            ->get();

        $productosDestacados = Producto::query()
            ->where('activo', true)
            ->with('categorias')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('tienda.index', compact('categoriasDestacadas', 'productosDestacados'));
    }

    public function catalogo(): View
    {
        return view('tienda.catalogo');
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
