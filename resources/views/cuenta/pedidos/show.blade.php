<x-layouts::tienda :title="__('Pedido #'.$pedido->id)">
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        @include('partials.account-nav')

        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="ui-title">Pedido #{{ $pedido->id }}</h1>
                <p class="ui-subtitle">Recibido el {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @php
                    $badge = match ($pedido->estado) {
                        'confirmado' => 'ui-badge-success',
                        'cancelado' => 'ui-badge-danger',
                        default => 'ui-badge-warning',
                    };
                @endphp
                <span class="{{ $badge }} text-sm">{{ ucfirst($pedido->estado) }}</span>
                <a href="{{ route('cliente.pedidos.index') }}" wire:navigate class="ui-btn-secondary shrink-0">
                    Volver
                </a>
            </div>
        </div>

        @if (session('mensaje'))
            <div class="ui-alert-success">{{ session('mensaje') }}</div>
        @endif

        @if (session('error'))
            <div class="ui-alert-error">{{ session('error') }}</div>
        @endif

        <div class="ui-card overflow-hidden">
            <div class="grid gap-6 border-b border-zinc-200 p-6 sm:grid-cols-3 dark:border-zinc-700">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Cliente</p>
                    <p class="mt-1 font-medium text-zinc-800 dark:text-zinc-100">{{ $pedido->nombre_cliente }}</p>
                    <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">{{ $pedido->telefono }}</p>
                    @if ($pedido->email)
                        <p class="mt-0.5 break-all text-sm text-zinc-500 dark:text-zinc-400">{{ $pedido->email }}</p>
                    @endif
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Entrega</p>
                    <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-200">{{ $pedido->direccion ?: 'Sin dirección' }}</p>
                    @if ($pedido->notas)
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $pedido->notas }}</p>
                    @endif
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Estado del pedido</p>
                    <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-200">
                        @if ($pedido->estado === 'pendiente')
                            Estamos revisando tu pedido para confirmarlo.
                        @elseif ($pedido->estado === 'confirmado')
                            Tu pedido fue confirmado y registrado como venta.
                        @else
                            Este pedido fue cancelado.
                        @endif
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th scope="col" class="ui-th text-left">Producto</th>
                            <th scope="col" class="ui-th text-center">Cantidad</th>
                            <th scope="col" class="ui-th text-right">Precio unitario</th>
                            <th scope="col" class="ui-th text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pedido->detallePedidos as $detalle)
                            <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="ui-td">
                                    <span class="block max-w-sm truncate font-medium text-zinc-800 dark:text-zinc-400">{{ $detalle->producto->nombre }}</span>
                                    <span class="block font-mono text-xs text-zinc-400 dark:text-zinc-500">{{ $detalle->producto->codigo }}</span>
                                </td>
                                <td class="ui-td text-center">{{ $detalle->cantidad }}</td>
                                <td class="ui-td whitespace-nowrap text-right tabular-nums">${{ number_format((float) $detalle->precio_unitario, 2) }}</td>
                                <td class="ui-td whitespace-nowrap text-right font-semibold tabular-nums">${{ number_format((float) $detalle->subtotal, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="ui-td text-center">Este pedido no tiene productos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-end border-t border-zinc-200 px-6 py-5 dark:border-zinc-700">
                <div class="text-right">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total del pedido</p>
                    <p class="mt-1 text-3xl font-bold tabular-nums text-zinc-800 dark:text-zinc-400">${{ number_format((float) $pedido->total, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap justify-end gap-3">
            @php($whatsapp = preg_replace('/\D+/', '', (string) config('services.whatsapp.number')))
            @if ($pedido->estado === 'pendiente' && filled($whatsapp))
                <a href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode('Hola, quiero consultar por mi pedido #'.$pedido->id.'.') }}" target="_blank" rel="noopener" class="ui-btn-secondary">
                    Consultar por WhatsApp
                </a>
            @endif

            @if ($pedido->estado === 'pendiente')
                <form action="{{ route('cliente.pedidos.cancelar', $pedido) }}" method="POST" data-confirm="¿Cancelar el pedido #{{ $pedido->id }}?">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="ui-btn-danger !px-5 !py-2.5 !text-sm">
                        Cancelar pedido
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-layouts::tienda>
