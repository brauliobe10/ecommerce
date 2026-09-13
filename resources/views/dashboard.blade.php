<x-layouts::app :title="__('Dashboard')">
    <div class="mx-auto max-w-7xl p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-400">Panel de control</h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Resumen general del comercio</p>
        </div>

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <a href="{{ route('usuarios.index') }}" class="ui-card p-6 transition-all hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Usuarios</p>
                        <p class="mt-2 text-4xl font-bold text-indigo-700 dark:text-indigo-400">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="flex size-12 items-center justify-center rounded-xl bg-sky-100 text-sky-600 dark:bg-sky-500/15 dark:text-sky-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>
            </a>

            <a href="{{ route('categorias.index') }}" class="ui-card p-6 transition-all hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Categorías</p>
                        <p class="mt-2 text-4xl font-bold text-indigo-700 dark:text-indigo-400">{{ \App\Models\Categoria::count() }}</p>
                    </div>
                    <div class="flex size-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>
                    </div>
                </div>
            </a>

            <a href="{{ route('productos.index') }}" class="ui-card p-6 transition-all hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Productos</p>
                        <p class="mt-2 text-4xl font-bold text-indigo-700 dark:text-indigo-400">{{ \App\Models\Producto::count() }}</p>
                    </div>
                    <div class="flex size-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                    </div>
                </div>
            </a>

            @php
                $ventasCompletadas = \App\Models\Venta::where('estado', 'completada')->get();
                $totalVentas = $ventasCompletadas->count();
                $montoVentas = $ventasCompletadas->sum('total');
            @endphp
            <a href="{{ route('ventas.index') }}" class="ui-card p-6 transition-all hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Ventas</p>
                        <p class="mt-2 text-4xl font-bold text-indigo-700 dark:text-indigo-400">{{ $totalVentas }}</p>
                        <p class="mt-1 text-sm font-semibold text-emerald-600 dark:text-emerald-400">${{ number_format($montoVentas, 2) }}</p>
                    </div>
                    <div class="flex size-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 2.25h1.5c.621 0 1.125.504 1.125 1.125v13.5c0 .621.504 1.125 1.125 1.125h15M5.25 15.75h15l-2.25-4.5-2.25 3-3.75-4.5-3 6-2.25-3-1.5 3z" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <div class="ui-card mt-4 p-6">
            <h2 class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">Bienvenido, {{ auth()->user()->name }}</h2>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                Usa el menú lateral para gestionar usuarios, categorías, productos, clientes y ventas.
            </p>
        </div>
    </div>
</x-layouts::app>