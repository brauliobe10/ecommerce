<div>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="ui-title">Pedidos</h1>
            <p class="ui-subtitle">Pedidos recibidos desde la tienda online</p>
        </div>
        <a href="{{ route('ventas.create') }}" class="ui-btn-success shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nueva Venta
        </a>
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

    <div class="ui-card mb-4 p-4 sm:p-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div class="w-full flex-1">
                <label for="buscar-pedido" class="ui-label">Buscar</label>
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    id="buscar-pedido"
                    icon="magnifying-glass"
                    clearable
                    placeholder="Por # de pedido, nombre o teléfono..."
                    autocomplete="off"
                    spellcheck="false"
                    class="w-full sm:max-w-md"
                />
            </div>

            @if ($search !== '' || $estado !== '')
                <button type="button" wire:click="clearFilters" class="ui-btn-secondary shrink-0 justify-center">
                    Limpiar filtros
                </button>
            @endif
        </div>

        <div class="mt-4">
            <span class="ui-label">Estado</span>
            <div class="inline-flex flex-wrap items-center gap-1 rounded-xl bg-zinc-100 p-1 dark:bg-zinc-800">
                <button
                    type="button"
                    wire:click="$set('estado', '')"
                    class="rounded-lg px-3 py-1.5 text-sm font-medium transition-all {{ $estado === '' ? 'bg-white text-indigo-700 shadow-sm dark:bg-zinc-700 dark:text-indigo-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}"
                >
                    Todos
                </button>
                @foreach ($estados as $value => $label)
                    <button
                        type="button"
                        wire:click="$set('estado', '{{ $value }}')"
                        class="rounded-lg px-3 py-1.5 text-sm font-medium transition-all {{ $estado === $value ? 'bg-white text-indigo-700 shadow-sm dark:bg-zinc-700 dark:text-indigo-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="ui-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th scope="col" class="ui-th text-left">#</th>
                        <th scope="col" class="ui-th text-left">Cliente</th>
                        <th scope="col" class="ui-th text-left">Teléfono</th>
                        <th scope="col" class="ui-th text-center">Productos</th>
                        <th scope="col" class="ui-th text-right">Total</th>
                        <th scope="col" class="ui-th text-center">Estado</th>
                        <th scope="col" class="ui-th text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="ui-td whitespace-nowrap font-mono text-zinc-400 dark:text-zinc-500">#{{ $pedido->id }}</td>
                            <td class="ui-td">
                                <span class="block max-w-xs truncate font-medium text-indigo-700 dark:text-indigo-400">{{ $pedido->nombre_cliente }}</span>
                                <span class="block text-xs text-zinc-400 dark:text-zinc-500">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="ui-td whitespace-nowrap tabular-nums">{{ $pedido->telefono }}</td>
                            <td class="ui-td text-center">{{ $pedido->detalle_pedidos_count }}</td>
                            <td class="ui-td whitespace-nowrap text-right font-semibold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($pedido->total, 2) }}</td>
                            <td class="ui-td text-center">
                                <div class="flex justify-center">
                                    @php
                                        $badge = match ($pedido->estado) {
                                            'confirmado' => 'ui-badge-success',
                                            'cancelado' => 'ui-badge-danger',
                                            default => 'ui-badge-warning',
                                        };
                                    @endphp
                                    <span class="{{ $badge }} whitespace-nowrap">{{ $estados[$pedido->estado] ?? ucfirst($pedido->estado) }}</span>
                                </div>
                            </td>
                            <td class="ui-td text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('pedidos.show', $pedido->id) }}" title="Ver detalle" class="ui-btn-edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Ver
                                    </a>

                                    @if ($pedido->estado === 'pendiente')
                                        <a href="{{ route('ventas.create', ['pedido' => $pedido->id]) }}" title="Confirmar en POS" class="ui-btn-success !px-3 !py-1.5 !text-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Confirmar
                                        </a>
                                    @endif

                                    @if ($pedido->estado !== 'confirmado')
                                        <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" onsubmit="return confirm('¿Eliminar el pedido #{{ $pedido->id }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Eliminar" class="ui-btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="flex flex-col items-center justify-center gap-4 px-6 py-20 text-center">
                                    <div class="ui-empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                        </svg>
                                    </div>
                                    <div>
                                        @if ($search !== '' || $estado !== '')
                                            <p class="font-medium text-zinc-700 dark:text-zinc-200">No hay pedidos que coincidan con los filtros</p>
                                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Ajusta los filtros o límpialos para ver todos los pedidos.</p>
                                        @else
                                            <p class="font-medium text-zinc-700 dark:text-zinc-200">No hay pedidos registrados</p>
                                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Los pedidos realizados desde la tienda aparecerán aquí.</p>
                                        @endif
                                    </div>
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
