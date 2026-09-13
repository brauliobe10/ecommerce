<?php

namespace App\Http\Controllers;

use App\Http\Requests\Venta\CreateVentaRequest;
use App\Models\Venta;
use App\Services\Venta\VentaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class VentaController extends Controller
{
    public function __construct(protected VentaService $service) {}

    public function index(): View
    {
        return view('venta.index');
    }

    public function create(): View
    {
        return view('venta.create');
    }

    public function store(CreateVentaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $venta = $this->service->store($data, $data['items']);

            return redirect()->route('ventas.show', $venta->id)
                ->with('mensaje', 'Venta registrada correctamente.');
        } catch (ValidationException $e) {
            return redirect()->route('ventas.create')
                ->withInput()
                ->withErrors($e->errors());
        }
    }

    public function show(int $id): View
    {
        $venta = $this->service->find($id);

        return view('venta.show', compact('venta'));
    }

    public function anular(Venta $venta): RedirectResponse
    {
        try {
            $this->service->anular($venta);

            return redirect()->route('ventas.show', $venta->id)
                ->with('mensaje', 'Venta anulada correctamente. El stock fue restaurado.');
        } catch (ValidationException $e) {
            return redirect()->route('ventas.show', $venta->id)
                ->with('error', $e->getMessage());
        }
    }
}
