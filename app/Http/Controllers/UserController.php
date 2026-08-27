<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct(protected UserService $service) {}

    public function index(Request $request)
    {
        $this->service->getAll();
    }

    public function create(User $user)
    {
        return view('usuario.action', ['user' => $user]);
    }

    public function store(Request $request)
    {
        $user = $this->service->store($request->validated());
        return redirect()->route('user.index')->with('mensaje', 'Usuario' . $user->name . 'agregado correctamente');
    }

    public function show() {}

    public function edit(int $id)
    {
        $user = $this->service->find($id);
        return view('usuario.action', compact('user'));
    }

    public function update(Request $request, int $id)
    {
        $user = $this->service->update($id, $request->validated());
        return redirect('usuario.index')->with('mensaje', 'Usuario' . $user->name . 'actualizado correctamente');
    }

    public function destroy(int $id)
    {
        $user = $this->service->destroy($id);
        return view('usuario.index')->with('Usuario' . $user->name . 'eliminado correctamente');
    }
}
