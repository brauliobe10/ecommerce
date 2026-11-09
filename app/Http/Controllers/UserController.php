<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(protected UserService $service) {}

    public function index(): View
    {
        return view('usuario.index');
    }

    public function create(): View
    {
        return view('usuario.action', ['usuario' => new User]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,vendedor'],
            'password' => ['required', 'string', Password::default(), 'confirmed'],
        ]);

        $user = $this->service->store($validated);

        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario '.$user->name.' agregado correctamente');
    }

    public function show(int $id): RedirectResponse
    {
        return redirect()->route('usuarios.index');
    }

    public function edit(int $id): View
    {
        $usuario = $this->service->find($id);

        return view('usuario.action', compact('usuario'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'role' => ['required', 'in:admin,vendedor'],
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        try {
            $user = $this->service->update($id, $validated);
        } catch (ValidationException $e) {
            return redirect()->route('usuarios.edit', $id)
                ->withErrors($e->errors())
                ->withInput();
        }

        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario '.$user->name.' actualizado correctamente');
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $user = $this->service->destroy($id);
        } catch (ValidationException $e) {
            return redirect()->route('usuarios.index')->with('error', $e->getMessage());
        }

        return redirect()->route('usuarios.index')->with('mensaje', 'Usuario '.$user->name.' eliminado correctamente');
    }
}
