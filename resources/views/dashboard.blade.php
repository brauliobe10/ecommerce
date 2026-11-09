<x-layouts::app :title="__('Dashboard')">
    @php
        $ingresosChart = [
            'labels' => $ingresos['labels'],
            'actual' => $ingresos['actual'],
            'anterior' => $ingresos['anterior'],
        ];

        $pedidosChart = [
            'labels' => $pedidos['labels'],
            'valores' => $pedidos['valores'],
        ];

        $metodosChart = [
            'labels' => $metodosPago['labels'],
            'valores' => $metodosPago['valores'],
        ];

        $hayIngresos = array_sum($ingresos['actual']) > 0;
        $hayPedidos = array_sum($pedidos['valores']) > 0;
        $hayMetodos = array_sum($metodosPago['valores']) > 0;
    @endphp

    <div class="mx-auto w-full max-w-7xl">
        <header class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-accent">Panel de control</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-text-primary sm:text-3xl">
                    Bienvenido de nuevo, {{ auth()->user()->name }}
                </h1>
                <p class="mt-1 text-sm text-text-secondary">
                    Esto es lo que está pasando en {{ config('app.name', 'KodeTech') }} hoy.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <span class="ui-badge-info">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    {{ now()->format('d/m/Y') }}
                </span>

                <a href="{{ route('ventas.index') }}" class="ui-btn-secondary">
                    Ver ventas
                </a>

                <a href="{{ route('ventas.create') }}" class="ui-btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nueva venta
                </a>
            </div>
        </header>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Indicadores del comercio">
            <x-dashboard.kpi-card
                label="Ingresos del mes"
                :value="'$'.number_format($resumen['ingresos']['valor'], 2)"
                :href="route('ventas.index')"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </x-slot>

                <x-slot name="trend">
                    <x-dashboard.trend-badge
                        :direccion="$resumen['ingresos']['variacion']['direccion']"
                        :porcentaje="$resumen['ingresos']['variacion']['porcentaje']"
                    />
                </x-slot>

                <x-slot name="subtext">vs. mes anterior</x-slot>
            </x-dashboard.kpi-card>

            <x-dashboard.kpi-card
                label="Ventas del mes"
                :value="number_format($resumen['ventas']['valor'])"
                :href="route('ventas.index')"
                icon-bg="bg-navy/5 text-navy dark:bg-white/10 dark:text-white"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </x-slot>

                <x-slot name="trend">
                    <x-dashboard.trend-badge
                        :direccion="$resumen['ventas']['variacion']['direccion']"
                        :porcentaje="$resumen['ventas']['variacion']['porcentaje']"
                    />
                </x-slot>

                <x-slot name="subtext">vs. mes anterior</x-slot>
            </x-dashboard.kpi-card>

            <x-dashboard.kpi-card
                label="Pedidos pendientes"
                :value="number_format($resumen['pedidos']['pendientes'])"
                :href="route('pedidos.index')"
                icon-bg="bg-amber-50 text-amber-700 dark:bg-amber-400/10 dark:text-amber-300"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </x-slot>

                <x-slot name="trend">
                    <span class="ui-badge-warning whitespace-nowrap">Por atender</span>
                </x-slot>

                <x-slot name="subtext">{{ $resumen['pedidos']['mes'] }} pedidos este mes</x-slot>
            </x-dashboard.kpi-card>

            <x-dashboard.kpi-card
                label="Clientes registrados"
                :value="number_format($resumen['clientes']['total'])"
                :href="route('clientes.index')"
                icon-bg="bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300"
            >
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </x-slot>

                <x-slot name="trend">
                    <x-dashboard.trend-badge
                        :direccion="$resumen['clientes']['variacion']['direccion']"
                        :porcentaje="$resumen['clientes']['variacion']['porcentaje']"
                    />
                </x-slot>

                <x-slot name="subtext">{{ $resumen['clientes']['nuevos'] }} nuevos este mes</x-slot>
            </x-dashboard.kpi-card>
        </section>

        <section class="mt-4 grid gap-4 xl:grid-cols-3" aria-label="Gráficos del comercio">
            <x-dashboard.chart-card
                title="Ingresos por ventas"
                :subtitle="'Últimos '.$meses.' meses · '.$ingresos['rango']"
                class="xl:col-span-2"
            >
                <x-slot name="actions">
                    <div class="inline-flex rounded-lg border border-border bg-surface-muted p-0.5">
                        @foreach ([6, 12] as $opcion)
                            <a
                                href="{{ route('dashboard', ['meses' => $opcion]) }}"
                                class="rounded-md px-2.5 py-1 text-xs font-semibold transition-colors {{ $meses === $opcion ? 'bg-surface text-text-primary shadow-sm dark:bg-white/10' : 'text-text-tertiary hover:text-text-primary' }}"
                                @if ($meses === $opcion) aria-current="page" @endif
                            >
                                {{ $opcion }}M
                            </a>
                        @endforeach
                    </div>
                </x-slot>

                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <p class="text-xs font-medium text-text-tertiary">Total del periodo</p>
                        <div class="mt-1 flex flex-wrap items-center gap-2">
                            <p class="text-2xl font-extrabold tracking-tight tabular-nums text-text-primary">
                                ${{ number_format($ingresos['total'], 2) }}
                            </p>
                            <x-dashboard.trend-badge
                                :direccion="$ingresos['variacion']['direccion']"
                                :porcentaje="$ingresos['variacion']['porcentaje']"
                            />
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-xs text-text-secondary">
                        <span class="inline-flex items-center gap-2">
                            <span class="size-2 rounded-full bg-accent"></span>
                            Periodo actual
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <span class="size-2 rounded-full bg-text-tertiary"></span>
                            Periodo anterior
                        </span>
                    </div>
                </div>

                <div class="mt-5">
                    @if ($hayIngresos)
                        <div class="relative h-80 sm:h-[30rem]">
                            <canvas
                                data-dashboard-chart="ingresos"
                                data-chart='@json($ingresosChart)'
                                role="img"
                                aria-label="Ingresos de los últimos {{ $meses }} meses comparados con el periodo anterior"
                            ></canvas>
                        </div>
                    @else
                        <div class="flex h-80 flex-col items-center justify-center gap-3 rounded-xl border border-dashed border-border bg-surface-muted/50 px-6 text-center sm:h-[30rem]">
                            <div class="ui-empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-text-primary">Aún no hay ingresos en este periodo</p>
                                <p class="mt-1 text-xs text-text-tertiary">Registra una venta para empezar a ver la evolución.</p>
                            </div>
                            <a href="{{ route('ventas.create') }}" class="ui-btn-secondary text-xs">Registrar venta</a>
                        </div>
                    @endif
                </div>
            </x-dashboard.chart-card>

            <div class="grid gap-4">
                <x-dashboard.chart-card
                    title="Métodos de pago"
                    :subtitle="'Ingresos · '.$metodosPago['rango']"
                >
                    <div class="flex items-end justify-between gap-3">
                        <div>
                            <p class="text-xs font-medium text-text-tertiary">Total cobrado</p>
                            <p class="mt-1 text-xl font-extrabold tracking-tight tabular-nums text-text-primary">
                                ${{ number_format($metodosPago['total'], 2) }}
                            </p>
                        </div>
                        <a href="{{ route('ventas.index') }}" class="text-xs font-semibold text-accent-strong hover:text-accent">Ver ventas</a>
                    </div>

                    @if ($hayMetodos)
                        <div class="relative mt-4 h-36">
                            <canvas
                                data-dashboard-chart="metodos"
                                data-chart='@json($metodosChart)'
                                role="img"
                                aria-label="Ingresos por método de pago"
                            ></canvas>
                        </div>
                    @else
                        <div class="mt-4 flex h-36 items-center justify-center rounded-xl border border-dashed border-border bg-surface-muted/50 px-4 text-center">
                            <p class="text-xs text-text-tertiary">Sin cobros registrados en este periodo.</p>
                        </div>
                    @endif

                    <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-[11px] text-text-secondary">
                        @foreach ($metodosPago['items'] as $item)
                            <span class="inline-flex items-center gap-1.5">
                                <span @class([
                                    'size-2 rounded-full',
                                    'bg-accent' => $item['metodo'] === \App\Models\Venta::METODO_EFECTIVO,
                                    'bg-text-primary' => $item['metodo'] === \App\Models\Venta::METODO_TARJETA,
                                    'bg-text-tertiary' => $item['metodo'] === \App\Models\Venta::METODO_TRANSFERENCIA,
                                ])></span>
                                {{ $item['label'] }}
                                <span class="font-semibold tabular-nums text-text-primary">${{ number_format($item['total'], 2) }}</span>
                            </span>
                        @endforeach
                    </div>
                </x-dashboard.chart-card>

                <x-dashboard.chart-card
                    title="Pedidos recibidos"
                    :subtitle="'Últimos '.$meses.' meses · '.$pedidos['rango']"
                >
                    <div class="flex items-end justify-between gap-3">
                        <div>
                            <p class="text-xs font-medium text-text-tertiary">Total del periodo</p>
                            <div class="mt-1 flex flex-wrap items-center gap-2">
                                <p class="text-xl font-extrabold tracking-tight tabular-nums text-text-primary">
                                    {{ number_format($pedidos['total']) }}
                                </p>
                                <x-dashboard.trend-badge
                                    :direccion="$pedidos['variacion']['direccion']"
                                    :porcentaje="$pedidos['variacion']['porcentaje']"
                                />
                            </div>
                        </div>
                        <a href="{{ route('pedidos.index') }}" class="text-xs font-semibold text-accent-strong hover:text-accent">Ver pedidos</a>
                    </div>

                    @if ($hayPedidos)
                        <div class="relative mt-4 h-32">
                            <canvas
                                data-dashboard-chart="pedidos"
                                data-chart='@json($pedidosChart)'
                                role="img"
                                aria-label="Pedidos recibidos en los últimos {{ $meses }} meses"
                            ></canvas>
                        </div>
                    @else
                        <div class="mt-4 flex h-32 items-center justify-center rounded-xl border border-dashed border-border bg-surface-muted/50 px-4 text-center">
                            <p class="text-xs text-text-tertiary">Sin pedidos registrados en este periodo.</p>
                        </div>
                    @endif
                </x-dashboard.chart-card>
            </div>
        </section>

        <section class="mt-4 grid gap-4 xl:grid-cols-3" aria-label="Actividad reciente">
            <div class="ui-card overflow-hidden xl:col-span-2">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-border px-5 py-4 sm:px-6">
                    <div>
                        <h2 class="text-sm font-semibold text-text-primary">Últimas ventas</h2>
                        <p class="mt-1 text-xs text-text-tertiary">Movimientos más recientes del comercio.</p>
                    </div>
                    <a href="{{ route('ventas.index') }}" class="text-xs font-semibold text-accent-strong hover:text-accent">Ver todas</a>
                </div>

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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ultimasVentas as $venta)
                                <tr class="transition-colors hover:bg-surface-muted dark:hover:bg-white/5">
                                    <td class="ui-td whitespace-nowrap font-mono text-text-tertiary">#{{ $venta->id }}</td>
                                    <td class="ui-td">
                                        <span class="block max-w-48 truncate font-medium text-text-primary">{{ $venta->cliente?->nombre ?? 'Cliente general' }}</span>
                                    </td>
                                    <td class="ui-td whitespace-nowrap tabular-nums">{{ $venta->fecha_venta->format('d/m/Y H:i') }}</td>
                                    <td class="ui-td text-center">
                                        <span class="ui-badge-info whitespace-nowrap">{{ ucfirst($venta->metodo_pago) }}</span>
                                    </td>
                                    <td class="ui-td whitespace-nowrap text-right font-semibold tabular-nums text-text-primary">${{ number_format($venta->total, 2) }}</td>
                                    <td class="ui-td text-center">
                                        <div class="flex justify-center">
                                            <span class="{{ $venta->estado === \App\Models\Venta::ESTADO_COMPLETADA ? 'ui-badge-success' : 'ui-badge-danger' }} whitespace-nowrap">
                                                <span class="size-1.5 rounded-full {{ $venta->estado === \App\Models\Venta::ESTADO_COMPLETADA ? 'bg-emerald-600' : 'bg-red-600' }}"></span>
                                                {{ $venta->estado === \App\Models\Venta::ESTADO_COMPLETADA ? 'Completada' : 'Anulada' }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="flex flex-col items-center justify-center gap-3 px-6 py-12 text-center">
                                            <div class="ui-empty-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-text-primary">Aún no hay ventas registradas</p>
                                                <p class="mt-1 text-xs text-text-tertiary">Registra tu primera venta para verla aquí.</p>
                                            </div>
                                            <a href="{{ route('ventas.create') }}" class="ui-btn-success text-xs">Nueva venta</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="ui-card p-5 sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-text-primary">Stock bajo</h2>
                        <p class="mt-1 text-xs text-text-tertiary">Productos con {{ \App\Models\Producto::STOCK_BAJO }} unidades o menos.</p>
                    </div>
                    <a href="{{ route('productos.index') }}" class="text-xs font-semibold text-accent-strong hover:text-accent">Ver productos</a>
                </div>

                <ul class="mt-5 space-y-3">
                    @forelse ($stockBajo as $producto)
                        <li class="flex items-center justify-between gap-3 rounded-lg border border-border bg-surface-muted/50 px-3 py-2.5">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-text-primary">{{ $producto->nombre }}</p>
                                <p class="mt-0.5 text-xs text-text-tertiary">{{ $producto->codigo }}</p>
                            </div>
                            <div class="flex shrink-0 items-center gap-2">
                                <span class="text-xs font-semibold tabular-nums text-text-secondary">${{ number_format($producto->precio, 2) }}</span>
                                <span class="{{ (int) $producto->stock === 0 ? 'ui-badge-danger' : 'ui-badge-warning' }} whitespace-nowrap">
                                    {{ $producto->stock }} {{ (int) $producto->stock === 1 ? 'unidad' : 'unidades' }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="flex flex-col items-center justify-center gap-3 rounded-lg border border-dashed border-border px-4 py-10 text-center">
                            <div class="ui-empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-text-primary">Todo el inventario está en orden</p>
                                <p class="mt-1 text-xs text-text-tertiary">No hay productos con stock bajo.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </section>
    </div>
</x-layouts::app>
