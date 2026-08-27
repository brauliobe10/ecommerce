<?php

namespace App\Http\Controllers;

use App\Http\Requests\Producto\CreateProductoRequest;
use App\Http\Requests\Producto\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use ProductoService;

class ProductoController extends Controller
{

    public function __construct(protected ProductoService $service) {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->service->getAll();
        return view('producto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('producto.action', ['producto' => new Producto()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductoRequest $request)
    {
        $producto = $this->service->store($request->validated());
        return redirect()->route('producto.index')->with('Producto' . $producto->name . 'agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $producto = $this->service->find($id);
        return view('producto.index', ['producto' => $producto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $producto = $this->service->find($id);
        return view('producto.action', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, int $id)
    {
        $producto = $this->service->update($id, $request->validated());

        return redirect()->route('productos.index')->with('mensaje', 'Producto ' . $producto->nombre . ' actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $producto = $this->service->destroy($id);
        return redirect()->route('productos.index')->with('mensaje', 'Producto ' . $producto->nombre . ' eliminado correctamente');
    }

    public function toggleStatus(Producto $producto)
    {
        $this->service->toggleStatus($producto);
        return redirect()->route('productos.index')
            ->with('mensaje', 'Estado del producto actualizado correctamente.');
    }
}
