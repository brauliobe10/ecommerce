<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\Categoria\CreateCategoryRequest;
use App\Http\Requests\Categoria\UpdateCategoyRequest;
use App\Services\Categoria\CategoriaService;

class CategoriaController extends Controller
{

    public function __construct(protected CategoriaService $service) {}

    public function index(Request $request )
    {
        $categorias = $this->service->getAll($request->only('estado'));
        return view('categoria.index', compact('categorias'));
    }

    public function create()
    {
        return view('categoria.action', ['categoria' => new Categoria()]);
    }

    public function store(CreateCategoryRequest $request)
    {

        $this->service->create($request->validated());

        return redirect()->route('categoria.index')->with('mensaje', 'Categoria creada correctamente');
    }

    public function show(int $id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categoria.index', ['categoria' => $categoria]);
    }

    public function edit(int $id)
    {
        $categoria = $this->service->find($id);
        return view('categoria.action', compact('categoria'));
    }

    public function update(UpdateCategoyRequest $request, int $id)
    {
        $categoria = $this->service->update($id, $request->validated());

        return redirect()->route('categoria.index')->with('mensaje', 'Categoria ' . $categoria->nombre . ' actualizada correctamente');
    }

    public function destroy(int $id)
    {

        $categoria = $this->service->destroy($id);

        return redirect()->route('categoria.index')->with('mensaje', 'Categoria ' . $categoria->nombre . ' eliminada correctamente');
    }

    public function toggleStatus(Categoria $categoria)
    {
        // Cambiar entre 'activo' e 'inactivo'
        $categoria->estado = ($categoria->estado === 'activo') ? 'inactivo' : 'activo';
        $categoria->save();

        return redirect()->route('categoria.index')
            ->with('mensaje', 'Estado de la categoría actualizado correctamente.');
    }
}
