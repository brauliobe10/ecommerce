<?php

namespace App\Services\WhatsApp;

use App\Models\Pedido;

class WhatsAppService
{
    public function urlPedido(Pedido $pedido): string
    {
        $pedido->loadMissing('detallePedidos.producto');

        $lineas = [];
        $lineas[] = "Hola, quiero confirmar mi pedido #{$pedido->id}.";
        $lineas[] = '';
        $lineas[] = "Cliente: {$pedido->nombre_cliente}";
        $lineas[] = "Teléfono: {$pedido->telefono}";

        if (filled($pedido->direccion)) {
            $lineas[] = "Dirección: {$pedido->direccion}";
        }

        $lineas[] = '';
        $lineas[] = 'Productos:';

        foreach ($pedido->detallePedidos as $detalle) {
            $lineas[] = "- {$detalle->cantidad} x {$detalle->producto->nombre} = $".number_format((float) $detalle->subtotal, 2);
        }

        $lineas[] = '';
        $lineas[] = 'Total: $'.number_format((float) $pedido->total, 2);

        if (filled($pedido->notas)) {
            $lineas[] = "Notas: {$pedido->notas}";
        }

        return $this->url($this->number(), implode("\n", $lineas));
    }

    public function number(): string
    {
        return preg_replace('/\D+/', '', (string) config('services.whatsapp.number')) ?? '';
    }

    public function url(string $number, string $mensaje): string
    {
        return 'https://wa.me/'.$number.'?text='.rawurlencode($mensaje);
    }
}
