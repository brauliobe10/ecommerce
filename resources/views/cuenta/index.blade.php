<x-layouts::tienda :title="__('Mi cuenta')">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        @include('partials.account-nav')

        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="ui-title">Mi cuenta</h1>
                <p class="ui-subtitle">Hola, {{ $user->name }}. Aquí puedes revisar tus datos y tus pedidos.</p>
            </div>
            <a href="{{ route('tienda.catalogo') }}" wire:navigate class="ui-btn-primary shrink-0">
                Seguir comprando
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="ui-card p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Datos de contacto</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="font-medium text-zinc-500 dark:text-zinc-400">Nombre</dt>
                        <dd class="mt-0.5 text-zinc-800 dark:text-zinc-100">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-500 dark:text-zinc-400">Correo</dt>
                        <dd class="mt-0.5 break-all text-zinc-800 dark:text-zinc-100">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-zinc-500 dark:text-zinc-400">Teléfono</dt>
                        <dd class="mt-0.5 text-zinc-800 dark:text-zinc-100">{{ $user->cliente?->telefono ?: 'Sin registrar' }}</dd>
                    </div>
                </dl>
                <a href="{{ route('profile.edit') }}" wire:navigate class="ui-btn-secondary mt-6 w-full justify-center">
                    Editar mis datos
                </a>
            </div>

            <div class="ui-card p-6 lg:col-span-2">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-sm font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Pedidos recientes</h2>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Tus últimas compras realizadas en la tienda.</p>
                    </div>
                    <a href="{{ route('cliente.pedidos.index') }}" wire:navigate class="text-sm font-semibold text-accent hover:underline">
                        Ver todos
                    </a>
                </div>

                @if ($pedidos->isEmpty())
                    <div class="mt-6 rounded-xl border border-dashed border-border px-6 py-12 text-center">
                        <p class="font-medium text-zinc-700 dark:text-zinc-200">Todavía no tienes pedidos.</p>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Cuando confirmes una compra aparecerá aquí.</p>
                    </div>
                @else
                    <div class="mt-5 divide-y divide-border">
                        @foreach ($pedidos as $pedido)
                            @php
                                $badge = match ($pedido->estado) {
                                    'confirmado' => 'ui-badge-success',
                                    'cancelado' => 'ui-badge-danger',
                                    default => 'ui-badge-warning',
                                };
                            @endphp
                            <a href="{{ route('cliente.pedidos.show', $pedido) }}" wire:navigate class="flex flex-wrap items-center justify-between gap-3 py-4 transition-colors hover:bg-surface-muted/60">
                                <div>
                                    <p class="font-semibold text-zinc-800 dark:text-zinc-100">Pedido #{{ $pedido->id }}</p>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $pedido->created_at->format('d/m/Y H:i') }} · {{ $pedido->detalle_pedidos_count }} producto(s)
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="{{ $badge }}">{{ ucfirst($pedido->estado) }}</span>
                                    <span class="font-semibold tabular-nums text-zinc-800 dark:text-zinc-100">${{ number_format((float) $pedido->total, 2) }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts::tienda>
