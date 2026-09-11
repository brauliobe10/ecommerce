<?php

namespace App\Http\Controllers;

use App\Http\Requests\Producto\CreateProductoRequest;
use App\Http\Requests\Producto\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use App\Services\Producto\ProductoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductoController extends Controller
{
    public function __construct(protected ProductoService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('producto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categorias = Categoria::where('estado', 'activo')->get();

        return view('producto.action', ['producto' => new Producto, 'categorias' => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = $this->service->store($data);

        if (! empty($data['categorias'])) {
            $producto->categorias()->sync($data['categorias']);
        }

        return redirect()->route('productos.index')->with('mensaje', 'Producto '.$producto->nombre.' agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): RedirectResponse
    {
        return redirect()->route('productos.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $producto = $this->service->find($id);
        $categorias = Categoria::where('estado', 'activo')->get();

        return view('producto.action', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        } elseif (array_key_exists('imagen', $data) && empty($data['imagen'])) {
            unset($data['imagen']);
        }

        $producto = $this->service->update($id, $data);

        if (array_key_exists('categorias', $data)) {
            $producto->categorias()->sync($data['categorias']);
        }

        return redirect()->route('productos.index')->with('mensaje', 'Producto '.$producto->nombre.' actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $producto = $this->service->destroy($id);

        return redirect()->route('productos.index')->with('mensaje', 'Producto '.$producto->nombre.' eliminado correctamente');
    }

    public function toggleStatus(Producto $producto): RedirectResponse
    {
        $this->service->toggleStatus($producto);

        return redirect()->route('productos.index')
            ->with('mensaje', 'Estado del producto actualizado correctamente.');
    }
}
