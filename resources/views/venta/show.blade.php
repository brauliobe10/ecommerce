<x-layouts::app :title="__('Venta #'.$venta->id)">
    <div class="mx-auto max-w-4xl p-6">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="ui-title">Venta #{{ $venta->id }}</h1>
                <p class="ui-subtitle">Detalle de la venta registrada el {{ $venta->fecha_venta->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="ui-btn-secondary shrink-0 !py-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659" />
                    </svg>
                    Imprimir
                </button>
                <a href="{{ route('ventas.index') }}" class="ui-btn-secondary shrink-0">
                    Volver al historial
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
                    <p class="mt-1 font-medium text-zinc-800 dark:text-zinc-100">{{ $venta->cliente?->nombre ?? 'Cliente general' }}</p>
                    @if ($venta->cliente?->telefono)
                        <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">{{ $venta->cliente->telefono }}</p>
                    @endif
                    @if ($venta->cliente?->email)
                        <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">{{ $venta->cliente->email }}</p>
                    @endif
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Registrada por</p>
                    <p class="mt-1 font-medium text-zinc-800 dark:text-zinc-100">{{ $venta->usuario->name }}</p>
                    <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">{{ $venta->fecha_venta->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Pago y estado</p>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="ui-badge-info">{{ ucfirst(str_replace('_', ' ', $venta->metodo_pago)) }}</span>
                    </div>
                    <div class="mt-2">
                        <span class="{{ $venta->estado === 'completada' ? 'ui-badge-success' : 'ui-badge-danger' }}">
                            <span class="size-1.5 rounded-full {{ $venta->estado === 'completada' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                            {{ ucfirst($venta->estado) }}
                        </span>
                    </div>
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
                        @forelse ($venta->detalleVentas as $detalle)
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
                                <td colspan="4" class="ui-td text-center">Esta venta no tiene productos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-end border-t border-zinc-200 px-6 py-5 dark:border-zinc-700">
                <div class="text-right">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total de la venta</p>
                    <p class="mt-1 text-3xl font-bold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($venta->total, 2) }}</p>
                </div>
            </div>
        </div>

        @if ($venta->estado === 'completada')
            <div class="mt-6 flex justify-end print:hidden">
                <form action="{{ route('ventas.anular', $venta->id) }}" method="POST" onsubmit="return confirm('¿Anular la venta #{{ $venta->id }}? El stock de los productos será restaurado.')">
                    @csrf
                    <button type="submit" class="ui-btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Anular venta
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-layouts::app>