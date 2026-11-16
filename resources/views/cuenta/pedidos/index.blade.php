<x-layouts::tienda :title="__('Mis pedidos')">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        @include('partials.account-nav')

        <div class="mb-8">
            <h1 class="ui-title">Mis pedidos</h1>
            <p class="ui-subtitle">Consulta el estado y el detalle de tus compras.</p>
        </div>

        @if (session('mensaje'))
            <div class="ui-alert-success">{{ session('mensaje') }}</div>
        @endif

        @if (session('error'))
            <div class="ui-alert-error">{{ session('error') }}</div>
        @endif

        @if ($pedidos->isEmpty())
            <div class="ui-card flex flex-col items-center justify-center gap-4 px-6 py-20 text-center">
                <div>
                    <p class="font-medium text-zinc-700 dark:text-zinc-200">No tienes pedidos registrados.</p>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Explora el catálogo y realiza tu primera compra.</p>
                </div>
                <a href="{{ route('tienda.catalogo') }}" wire:navigate class="ui-btn-primary">
                    Ir al catálogo
                </a>
            </div>
        @else
            {{-- Celulares: lista de tarjetas --}}
            <div class="ui-card divide-y divide-border md:hidden">
                @foreach ($pedidos as $pedido)
                    @php
                        $badge = match ($pedido->estado) {
                            'confirmado' => 'ui-badge-success',
                            'cancelado' => 'ui-badge-danger',
                            default => 'ui-badge-warning',
                        };
                    @endphp
                    <a href="{{ route('cliente.pedidos.show', $pedido) }}" wire:navigate class="flex flex-col gap-3 px-4 py-4 transition-colors hover:bg-surface-muted/60 dark:hover:bg-white/5">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-semibold text-zinc-800 dark:text-zinc-100">Pedido #{{ $pedido->numero_cliente }}</p>
                            <span class="{{ $badge }}">{{ ucfirst($pedido->estado) }}</span>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-2 text-sm">
                            <span class="text-zinc-500 dark:text-zinc-400">{{ $pedido->created_at->format('d/m/Y H:i') }} · {{ $pedido->detalle_pedidos_count }} producto(s)</span>
                            <span class="font-semibold tabular-nums text-zinc-800 dark:text-zinc-100">${{ number_format((float) $pedido->total, 2) }}</span>
                        </div>

                        <span class="inline-flex w-fit items-center gap-1 text-sm font-semibold text-accent">
                            Ver detalle
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Tablets y escritorio: tabla --}}
            <div class="ui-card hidden overflow-hidden md:block">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th scope="col" class="ui-th text-left">Pedido</th>
                                <th scope="col" class="ui-th text-left">Fecha</th>
                                <th scope="col" class="ui-th text-center">Productos</th>
                                <th scope="col" class="ui-th text-center">Estado</th>
                                <th scope="col" class="ui-th text-right">Total</th>
                                <th scope="col" class="ui-th text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                @php
                                    $badge = match ($pedido->estado) {
                                        'confirmado' => 'ui-badge-success',
                                        'cancelado' => 'ui-badge-danger',
                                        default => 'ui-badge-warning',
                                    };
                                @endphp
                                <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="ui-td whitespace-nowrap font-semibold">#{{ $pedido->numero_cliente }}</td>
                                    <td class="ui-td whitespace-nowrap">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="ui-td text-center">{{ $pedido->detalle_pedidos_count }}</td>
                                    <td class="ui-td text-center">
                                        <span class="{{ $badge }}">{{ ucfirst($pedido->estado) }}</span>
                                    </td>
                                    <td class="ui-td whitespace-nowrap text-right font-semibold tabular-nums">${{ number_format((float) $pedido->total, 2) }}</td>
                                    <td class="ui-td text-center">
                                        <a href="{{ route('cliente.pedidos.show', $pedido) }}" wire:navigate class="ui-btn-edit">
                                            Ver detalle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($pedidos->hasPages())
                <div class="mt-6">
                    {{ $pedidos->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts::tienda>
