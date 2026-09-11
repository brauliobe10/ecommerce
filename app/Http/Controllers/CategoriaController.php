<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categoria\CreateCategoryRequest;
use App\Http\Requests\Categoria\UpdateCategoyRequest;
use App\Models\Categoria;
use App\Services\Categoria\CategoriaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoriaController extends Controller
{
    public function __construct(protected CategoriaService $service) {}

    public function index(): View
    {
        return view('categoria.index');
    }

    public function create(): View
    {
        return view('categoria.action', ['categoria' => new Categoria]);
    }

    public function store(CreateCategoryRequest $request): RedirectResponse
    {

        $this->service->store($request->validated());

        return redirect()->route('categorias.index')->with('mensaje', 'Categoria creada correctamente');
    }

    public function show(int $id): RedirectResponse
    {
        return redirect()->route('categorias.index');
    }

    public function edit(int $id): View
    {
        $categoria = $this->service->find($id);

        return view('categoria.action', compact('categoria'));
    }

    public function update(UpdateCategoyRequest $request, int $id): RedirectResponse
    {
        $categoria = $this->service->update($id, $request->validated());

        return redirect()->route('categorias.index')->with('mensaje', 'Categoria '.$categoria->nombre.' actualizada correctamente');
    }

    public function destroy(int $id): RedirectResponse
    {
        $categoria = $this->service->destroy($id);

        return redirect()->route('categorias.index')->with('mensaje', 'Categoria '.$categoria->nombre.' eliminada correctamente');
    }

    public function toggleStatus(Categoria $categoria): RedirectResponse
    {
        $this->service->toggleStatus($categoria);

        return redirect()->route('categorias.index')
            ->with('mensaje', 'Estado de la categoría actualizado correctamente.');
    }
}
