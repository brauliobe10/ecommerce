<div>
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

    <div class="ui-glass -mx-4 px-4 py-5 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Catálogo de productos</h2>
                <p class="ui-subtitle">
                    <span wire:loading.remove wire:target="search, categoria, filtrarCategoria">
                        {{ $productos->total() === 1 ? '1 producto' : $productos->total().' productos' }} disponibles
                    </span>
                    <span wire:loading wire:target="search, categoria, filtrarCategoria">Buscando...</span>
                </p>
            </div>

            <flux:input
                wire:model.live.debounce.300ms="search"
                icon="magnifying-glass"
                clearable
                placeholder="Buscar productos..."
                autocomplete="off"
                class="lg:w-72"
            />
        </div>

        <div class="mt-4 flex gap-2 overflow-x-auto pb-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            <button
                type="button"
                wire:click="filtrarCategoria"
                @class(['ui-glass-chip', 'ui-glass-chip-active' => $categoria === ''])
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                Todas
                <span class="ui-glass-chip-count">{{ $total }}</span>
            </button>

            @foreach ($categorias as $cat)
                <button
                    type="button"
                    wire:click="filtrarCategoria({{ $cat->id }})"
                    @class(['ui-glass-chip', 'ui-glass-chip-active' => $categoria === (string) $cat->id])
                >
                    {{ $cat->nombre }}
                    <span class="ui-glass-chip-count">{{ $cat->cantidad_productos }}</span>
                </button>
            @endforeach
        </div>
    </div>

    @if ($search !== '' || $categoria !== '')
        <div class="mt-4">
            <button type="button" wire:click="clearFilters" class="ui-btn-secondary !px-4 !py-2 text-sm">
                Limpiar filtros
            </button>
        </div>
    @endif

    <div wire:loading.block wire:target="search, categoria, filtrarCategoria" class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @for ($i = 0; $i < 8; $i++)
            <div class="ui-glass overflow-hidden">
                <div class="ui-skeleton aspect-square rounded-none"></div>
                <div class="space-y-3 p-5">
                    <div class="ui-skeleton h-4 w-2/3"></div>
                    <div class="ui-skeleton h-4 w-1/2"></div>
                    <div class="ui-skeleton h-11 w-full"></div>
                </div>
            </div>
        @endfor
    </div>

    <div wire:loading.remove wire:target="search, categoria, filtrarCategoria" class="mt-8">
        @if ($productos->isEmpty())
            <div class="ui-glass flex flex-col items-center justify-center gap-4 px-6 py-20 text-center">
                <div class="ui-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-zinc-700 dark:text-zinc-200">No se encontraron productos</p>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Prueba con otra búsqueda o categoría.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($productos as $producto)
                    <div class="ui-glass group flex flex-col overflow-hidden transition-all hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/10 dark:hover:shadow-indigo-900/20">
                        <div class="relative">
                            <a href="{{ route('tienda.producto', $producto->id) }}" wire:navigate class="block aspect-square overflow-hidden bg-zinc-100/60 dark:bg-zinc-800/60">
                                @if ($producto->imagen)
                                    <img src="{{ asset('storage/'.$producto->imagen) }}" alt="{{ $producto->nombre }}" class="size-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <div class="flex size-full items-center justify-center text-zinc-300 dark:text-zinc-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 8.25h.008v.008H18V8.25zm3 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            <div class="absolute left-3 top-3 flex items-center gap-2">
                                @foreach ($producto->categorias->take(1) as $cat)
                                    <span class="rounded-full bg-white/80 px-3 py-1 text-xs font-semibold text-zinc-700 backdrop-blur-xl dark:bg-zinc-950/60 dark:text-zinc-300">{{ $cat->nombre }}</span>
                                @endforeach
                            </div>

                            @if ($producto->stock > 0)
                                <span class="absolute right-3 top-3 rounded-full bg-emerald-600/90 px-3 py-1 text-xs font-semibold text-white backdrop-blur-xl">En stock</span>
                            @else
                                <span class="absolute right-3 top-3 rounded-full bg-red-600/90 px-3 py-1 text-xs font-semibold text-white backdrop-blur-xl">Agotado</span>
                            @endif
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <span class="font-mono text-xs text-zinc-400 dark:text-zinc-500">{{ $producto->codigo }}</span>

                            <a href="{{ route('tienda.producto', $producto->id) }}" wire:navigate class="mt-2 line-clamp-2 font-semibold text-zinc-800 transition hover:text-indigo-600 dark:text-zinc-100 dark:hover:text-indigo-400">
                                {{ $producto->nombre }}
                            </a>

                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xl font-bold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($producto->precio, 2) }}</span>
                            </div>

                            <div class="mt-4 flex-1"></div>

                            <button
                                type="button"
                                wire:click="addToCart({{ $producto->id }})"
                                @disabled($producto->stock <= 0)
                                class="ui-btn-success w-full justify-center disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                                Agregar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($productos->hasPages())
                <div class="mt-8">
                    {{ $productos->links() }}
                </div>
            @endif
        @endif
    </div>
</div>