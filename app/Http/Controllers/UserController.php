<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\User\UserService;

class UserController extends Controller
{

    public function __construct(protected UserService $service) {}

    public function index(Request $request)
    {
        $usuarios = $this->service->getAll();
        return view('usuario.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuario.action', ['usuario' => new User()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $this->service->store($validated);
        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario ' . $user->name . ' agregado correctamente');
    }

    public function show(int $id)
    {
        return redirect()->route('usuarios.index');
    }

    public function edit(int $id)
    {
        $usuario = $this->service->find($id);
        return view('usuario.action', compact('usuario'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user = $this->service->update($id, $validated);
        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario ' . $user->name . ' actualizado correctamente');
    }

    public function destroy(int $id)
    {
        $user = $this->service->destroy($id);
        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario ' . $user->name . ' eliminado correctamente');
    }
}
