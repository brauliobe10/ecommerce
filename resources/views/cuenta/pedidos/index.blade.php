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

        <div class="ui-card overflow-hidden">
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
                        @forelse ($pedidos as $pedido)
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
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="flex flex-col items-center justify-center gap-4 px-6 py-20 text-center">
                                        <div>
                                            <p class="font-medium text-zinc-700 dark:text-zinc-200">No tienes pedidos registrados.</p>
                                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Explora el catálogo y realiza tu primera compra.</p>
                                        </div>
                                        <a href="{{ route('tienda.catalogo') }}" wire:navigate class="ui-btn-primary">
                                            Ir al catálogo
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($pedidos->hasPages())
            <div class="mt-6">
                {{ $pedidos->links() }}
            </div>
        @endif
    </div>
</x-layouts::tienda>
