<div>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="ui-title">Ventas</h1>
            <p class="ui-subtitle">Historial de ventas del comercio</p>
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
                <label for="buscar-venta" class="ui-label">Buscar</label>
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    id="buscar-venta"
                    icon="magnifying-glass"
                    clearable
                    placeholder="Por # de venta o cliente..."
                    autocomplete="off"
                    spellcheck="false"
                    class="w-full sm:max-w-md"
                />
            </div>

            @if ($this->hasActiveFilters())
                <button
                    type="button"
                    wire:click="clearFilters"
                    class="ui-btn-secondary shrink-0 justify-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Limpiar filtros
                </button>
            @endif
        </div>

        <div class="mt-4 grid gap-4 md:grid-cols-3">
            <div>
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

            <div>
                <span class="ui-label">Método de pago</span>
                <div class="inline-flex flex-wrap items-center gap-1 rounded-xl bg-zinc-100 p-1 dark:bg-zinc-800">
                    <button
                        type="button"
                        wire:click="$set('metodo_pago', '')"
                        class="rounded-lg px-3 py-1.5 text-sm font-medium transition-all {{ $metodo_pago === '' ? 'bg-white text-indigo-700 shadow-sm dark:bg-zinc-700 dark:text-indigo-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}"
                    >
                        Todos
                    </button>
                    @foreach ($metodosPago as $value => $label)
                        <button
                            type="button"
                            wire:click="$set('metodo_pago', '{{ $value }}')"
                            class="rounded-lg px-3 py-1.5 text-sm font-medium transition-all {{ $metodo_pago === $value ? 'bg-white text-indigo-700 shadow-sm dark:bg-zinc-700 dark:text-indigo-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div>
                <span class="ui-label">Fecha</span>
                <div class="flex flex-wrap items-center gap-1.5">
                    @foreach (['hoy' => 'Hoy', '7dias' => '7 días', 'este_mes' => 'Este mes', 'este_anio' => 'Este año'] as $value => $label)
                        @php
                            [$desde, $hasta] = $this->datePresetRange($value);
                            $active = $fecha_desde === $desde && $fecha_hasta === $hasta;
                        @endphp
                        <button
                            type="button"
                            wire:click="applyDatePreset('{{ $value }}')"
                            class="rounded-lg border px-2.5 py-1.5 text-xs font-medium transition-all {{ $active ? 'border-indigo-500 bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400' : 'border-zinc-200 text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 dark:border-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <div class="mt-2 flex flex-col gap-2 sm:flex-row">
                    <flux:input.group>
                        <flux:input wire:model.live="fecha_desde" type="date" aria-label="Fecha desde" />
                    </flux:input.group>
                    <flux:input.group>
                        <flux:input wire:model.live="fecha_hasta" type="date" aria-label="Fecha hasta" />
                    </flux:input.group>
                </div>
                <p class="ui-note">Se aplica el rango completo de cada día seleccionado.</p>
            </div>
        </div>

        @if ($this->hasActiveFilters())
            <div class="mt-4 border-t border-zinc-100 pt-3 dark:border-zinc-800">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                        {{ $this->activeFiltersCount() }} {{ $this->activeFiltersCount() === 1 ? 'filtro aplicado' : 'filtros aplicados' }}
                    </span>
                    @if ($search !== '')
                        <button type="button" wire:click="resetOneFilter('search')" class="ui-badge-info cursor-pointer transition-transform hover:scale-105">
                            Búsqueda: "{{ $search }}"
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                    @if ($estado !== '')
                        <button type="button" wire:click="resetOneFilter('estado')" class="ui-badge-info cursor-pointer transition-transform hover:scale-105">
                            Estado: {{ $estados[$estado] ?? ucfirst($estado) }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                    @if ($metodo_pago !== '')
                        <button type="button" wire:click="resetOneFilter('metodo_pago')" class="ui-badge-info cursor-pointer transition-transform hover:scale-105">
                            Método: {{ $metodosPago[$metodo_pago] ?? ucfirst($metodo_pago) }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                    @if ($fecha_desde !== '')
                        <button type="button" wire:click="resetOneFilter('fecha_desde')" class="ui-badge-info cursor-pointer transition-transform hover:scale-105">
                            Desde: {{ \Carbon\CarbonImmutable::parse($fecha_desde)->format('d/m/Y') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                    @if ($fecha_hasta !== '')
                        <button type="button" wire:click="resetOneFilter('fecha_hasta')" class="ui-badge-info cursor-pointer transition-transform hover:scale-105">
                            Hasta: {{ \Carbon\CarbonImmutable::parse($fecha_hasta)->format('d/m/Y') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
            <span class="ui-badge-info whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
                {{ number_format($resumen['cantidad']) }} {{ $resumen['cantidad'] === 1 ? 'venta' : 'ventas' }}
            </span>
            <span class="ui-badge-success whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Total: ${{ number_format($resumen['total'], 2) }}
            </span>
        </div>

        <p class="text-sm text-zinc-500 dark:text-zinc-400">
            Mostrando
            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $ventas->firstItem() ?? 0 }}</span> –
            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $ventas->lastItem() ?? 0 }}</span>
            de
            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $ventas->total() }}</span>
        </p>
    </div>

    <div class="ui-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th scope="col" class="ui-th text-left">#</th>
                        <th scope="col" class="ui-th text-left">Cliente</th>
                        <th scope="col" class="ui-th text-left">Fecha</th>
                        <th scope="col" class="ui-th text-center">Método</th>
                        <th scope="col" class="ui-th text-right">Total</th>
                        <th scope="col" class="ui-th text-center">Estado</th>
                        <th scope="col" class="ui-th text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventas as $venta)
                        <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="ui-td whitespace-nowrap font-mono text-zinc-400 dark:text-zinc-500">#{{ $venta->id }}</td>
                            <td class="ui-td">
                                <span class="block max-w-xs truncate font-medium text-indigo-700 dark:text-indigo-400">{{ $venta->cliente?->nombre ?? 'Cliente general' }}</span>
                            </td>
                            <td class="ui-td whitespace-nowrap">
                                <span class="tabular-nums">{{ $venta->fecha_venta->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="ui-td text-center">
                                <span class="ui-badge-info whitespace-nowrap">{{ $metodosPago[$venta->metodo_pago] ?? ucfirst($venta->metodo_pago) }}</span>
                            </td>
                            <td class="ui-td whitespace-nowrap text-right font-semibold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($venta->total, 2) }}</td>
                            <td class="ui-td text-center">
                                <div class="flex justify-center">
                                    <span class="{{ $venta->estado === 'completada' ? 'ui-badge-success' : 'ui-badge-danger' }} whitespace-nowrap">
                                        <span class="size-1.5 rounded-full {{ $venta->estado === 'completada' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                        {{ $estados[$venta->estado] ?? ucfirst($venta->estado) }}
                                    </span>
                                </div>
                            </td>
                            <td class="ui-td text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('ventas.show', $venta->id) }}" title="Ver detalle" class="ui-btn-edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Ver
                                    </a>
                                    @if ($venta->estado === 'completada')
                                        <form action="{{ route('ventas.anular', $venta->id) }}" method="POST" onsubmit="return confirm('¿Anular la venta #{{ $venta->id }}? El stock de los productos será restaurado.')">
                                            @csrf
                                            <button type="submit" title="Anular venta" class="ui-btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        @if ($this->hasActiveFilters())
                                            <p class="font-medium text-zinc-700 dark:text-zinc-200">No hay ventas que coincidan con los filtros</p>
                                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Ajusta los filtros aplicados o límpialos para ver todas las ventas.</p>
                                        @else
                                            <p class="font-medium text-zinc-700 dark:text-zinc-200">No hay ventas registradas</p>
                                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Registra tu primera venta para comenzar a llevar el historial.</p>
                                        @endif
                                    </div>
                                    @if ($this->hasActiveFilters())
                                        <button
                                            type="button"
                                            wire:click="clearFilters"
                                            class="ui-btn-secondary"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Limpiar filtros
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($ventas->hasPages())
        <div class="mt-6">
            {{ $ventas->links() }}
        </div>
    @endif
</div>