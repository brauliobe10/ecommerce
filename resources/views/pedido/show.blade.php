<x-layouts::app :title="__('Pedido #'.$pedido->id)">
    <div class="mx-auto max-w-4xl p-6">
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
                <button onclick="window.print()" class="ui-btn-secondary shrink-0 !py-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659" />
                    </svg>
                    Imprimir
                </button>
                <a href="{{ route('pedidos.index') }}" class="ui-btn-secondary shrink-0" wire:navigate>
                    Volver
                </a>
            </div>
        </div>

        @if (session('mensaje'))
            <div class="ui-alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('mensaje') }}
            </div>
        @endif

        @if (session('error'))
            <div class="ui-alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="ui-card overflow-hidden print:shadow-none">
            <div class="grid gap-6 border-b border-zinc-200 p-6 sm:grid-cols-3 dark:border-zinc-700">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Cliente</p>
                    <p class="mt-1 font-medium text-zinc-800 dark:text-zinc-100">{{ $pedido->nombre_cliente }}</p>
                    <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">{{ $pedido->telefono }}</p>
                    @if ($pedido->email)
                        <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">{{ $pedido->email }}</p>
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
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Venta asociada</p>
                    @if ($pedido->venta)
                        <a href="{{ route('ventas.show', $pedido->venta->id) }}" class="mt-1 inline-block font-medium text-indigo-600 underline-offset-4 hover:underline dark:text-indigo-400">
                            Venta #{{ $pedido->venta->id }}
                        </a>
                    @else
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Aún no confirmado</p>
                    @endif
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
                                    <span class="block max-w-sm truncate font-medium text-indigo-700 dark:text-indigo-400">{{ $detalle->producto->nombre }}</span>
                                    <span class="block font-mono text-xs text-zinc-400 dark:text-zinc-500">{{ $detalle->producto->codigo }}</span>
                                </td>
                                <td class="ui-td text-center">{{ $detalle->cantidad }}</td>
                                <td class="ui-td whitespace-nowrap text-right tabular-nums">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td class="ui-td whitespace-nowrap text-right font-semibold tabular-nums">${{ number_format($detalle->subtotal, 2) }}</td>
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
                    <p class="mt-1 text-3xl font-bold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($pedido->total, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap justify-end gap-3 print:hidden">
            @php($whatsapp = preg_replace('/\D+/', '', (string) $pedido->telefono))
            @if (filled($whatsapp))
                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="ui-btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Contactar cliente
                </a>
            @endif

            @if ($pedido->estado === 'pendiente')
                <a href="{{ route('ventas.create', ['pedido' => $pedido->id]) }}" class="ui-btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Confirmar en POS
                </a>

                <form action="{{ route('pedidos.cancelar', $pedido->id) }}" method="POST" onsubmit="return confirm('¿Cancelar el pedido #{{ $pedido->id }}?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="ui-btn-danger !px-5 !py-2.5 !text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Cancelar pedido
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-layouts::app>
