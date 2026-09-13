<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cliente\CreateClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use App\Models\Cliente;
use App\Services\Cliente\ClienteService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ClienteController extends Controller
{
    public function __construct(protected ClienteService $service) {}

    public function index(): View
    {
        return view('cliente.index');
    }

    public function create(): View
    {
        return view('cliente.action', ['cliente' => new Cliente]);
    }

    public function store(CreateClienteRequest $request): RedirectResponse
    {
        $cliente = $this->service->store($request->validated());

        return redirect()->route('clientes.index')->with('mensaje', 'Cliente '.$cliente->nombre.' agregado correctamente');
    }

    public function show(int $id): RedirectResponse
    {
        return redirect()->route('clientes.index');
    }

    public function edit(int $id): View
    {
        $cliente = $this->service->find($id);

        return view('cliente.action', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, int $id): RedirectResponse
    {
        $cliente = $this->service->update($id, $request->validated());

        return redirect()->route('clientes.index')->with('mensaje', 'Cliente '.$cliente->nombre.' actualizado correctamente');
    }

    public function destroy(int $id): RedirectResponse
    {
        $cliente = $this->service->destroy($id);

        return redirect()->route('clientes.index')->with('mensaje', 'Cliente '.$cliente->nombre.' eliminado correctamente');
    }
}
