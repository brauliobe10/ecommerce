<x-layouts::app :title="__('Registrar Venta')">
    <div class="mx-auto max-w-5xl p-6">
        <livewire:ventas.create :pedido-id="$pedidoId ?? null" />
    </div>
</x-layouts::app>
