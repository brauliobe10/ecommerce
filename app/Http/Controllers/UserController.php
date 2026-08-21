<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('usuario.index');
    }

    public function create()
    {
        return view('usuario.action');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();
        return redirect('usuario.index')->with('mensaje', 'Usuario' . $user->id . 'agregado correctamente');
    }

    public function show() {}

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('usuario.action', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect('usuario.index')->with('mensaje', 'Usuario' . $user->id . 'actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return view('usuario.index')->with('Usuario' . $user->id . 'eliminado correctamente');
    }
}
