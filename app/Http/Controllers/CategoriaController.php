<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('productos')->get();
         return view ('categoria.index' , compact('categorias'));
        //return response()->json($categorias);
    }

    public function create()
    {
        return view('categoria.action');
    }

    public function store(Request $request)
    {
        $categoria = $request->input('name');
        $categoria = $request->input('descripcion');
        $categoria = $request->input('activo');

        $categoria->save();

        return redirect()->route('categoria.index')->with('mensaje', 'Categoria ' . $categoria->nombre . ' ingresada correctamente');
    }

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categoria.index', ['categoria' => $categoria]);
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categoria.action', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria = $request->input('name');
        $categoria = $request->input('descripcion');
        $categoria = $request->input('activo');
        $categoria->save();

        return redirect()->route('categoria.index')->with('mensaje', 'Categoria ' . $categoria->nombre . ' actualizada correctamente');
    }

    public function destroy($id){
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categoria.index')->with('mensaje' , 'Categoria' . $categoria->nombre . ' eliminada correctamente');
    }

    public function toggleStatus(Categoria $categoria){ //funcion para cambiar el estado de las categorias
        $categoria->activo =! $categoria->activo;
        $categoria->save();
        return redirect()->route('usuarios.index')->with('mensaje' , 'Estado de la categoria actualizado correctamente.');
    }
}
