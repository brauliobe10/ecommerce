<?php

namespace App\Livewire\Ventas;

use App\Http\Requests\Venta\CreateVentaRequest;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Venta;
use App\Services\Pedido\PedidoService;
use App\Services\Venta\VentaService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Create extends Component
{
    public ?int $pedidoId = null;

    public string $cliente_id = '';

    public string $metodo_pago = Venta::METODO_EFECTIVO;

    public string $estado = Venta::ESTADO_COMPLETADA;

    /** @var array<int, array{key: int, producto_id: string, cantidad: string}> */
    public array $items = [];

    private int $nextKey = 0;

    public function mount(?int $pedidoId = null): void
    {
        if ($pedidoId !== null) {
            $pedido = Pedido::with('detallePedidos')->find($pedidoId);

            if ($pedido && $pedido->estado === Pedido::ESTADO_PENDIENTE) {
                $this->pedidoId = $pedido->id;
                $this->cliente_id = (string) ($pedido->cliente_id ?? '');

                foreach ($pedido->detallePedidos as $detalle) {
                    $this->items[] = [
                        'key' => $this->nextKey++,
                        'producto_id' => (string) $detalle->producto_id,
                        'cantidad' => (string) $detalle->cantidad,
                    ];
                }
            }
        }

        if ($this->items === []) {
            $this->addItem();
        }
    }

    public function addItem(): void
    {
        $this->items[] = [
            'key' => $this->nextKey++,
            'producto_id' => '',
            'cantidad' => '1',
        ];
    }

    public function removeItem(int $key): void
    {
        $this->items = array_values(array_filter(
            $this->items,
            fn (array $item) => $item['key'] !== $key
        ));
    }

    public function getTotalProperty(): float
    {
        $total = 0;

        foreach ($this->items as $item) {
            $producto = Producto::find($item['producto_id']);
            if ($producto) {
                $total += $producto->precio * max((int) $item['cantidad'], 0);
            }
        }

        return round($total, 2);
    }

    public function store(): void
    {
        $rules = (new CreateVentaRequest)->rules();
        unset($rules['fecha_venta']);
        $this->validate($rules);

        $pedido = null;

        if ($this->pedidoId !== null) {
            $pedido = Pedido::find($this->pedidoId);

            if (! $pedido || $pedido->estado !== Pedido::ESTADO_PENDIENTE) {
                $this->addError('items', 'El pedido ya no se encuentra pendiente.');

                return;
            }
        }

        $items = collect($this->items)
            ->map(fn (array $item) => [
                'producto_id' => (int) $item['producto_id'],
                'cantidad' => (int) $item['cantidad'],
            ])
            ->values()
            ->all();

        try {
            $venta = app(VentaService::class)->store([
                'cliente_id' => $this->cliente_id !== '' ? (int) $this->cliente_id : null,
                'metodo_pago' => $this->metodo_pago,
                'estado' => $this->estado,
            ], $items);

            $pedidoConfirmado = null;

            if ($pedido !== null) {
                app(PedidoService::class)->confirmar($pedido, $venta);
                $pedidoConfirmado = $pedido->id;
            }
        } catch (ValidationException $e) {
            $this->addError('items', $e->getMessage());

            return;
        }

        $this->reset('cliente_id', 'items');
        $this->mount();

        $mensaje = 'Venta #'.$venta->id.' registrada correctamente. Total: $'.number_format($venta->total, 2);

        if ($pedidoConfirmado !== null) {
            $mensaje .= ' Pedido #'.$pedidoConfirmado.' confirmado.';
        }

        session()->flash('mensaje', $mensaje);

        $this->redirectRoute('ventas.show', $venta->id, navigate: true);
    }

    public function render(): View
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();

        $pedido = $this->pedidoId !== null ? Pedido::find($this->pedidoId) : null;

        return view('livewire.ventas.create', compact('clientes', 'productos', 'pedido'));
    }
}
