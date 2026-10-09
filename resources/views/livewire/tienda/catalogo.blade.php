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

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Catálogo</h2>
            <p class="ui-subtitle">Encuentra tus productos y agrégalos al carrito</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <flux:input
                wire:model.live.debounce.300ms="search"
                icon="magnifying-glass"
                clearable
                placeholder="Buscar productos..."
                autocomplete="off"
                class="sm:w-64"
            />
            <select wire:model.live="categoria" class="ui-input cursor-pointer sm:w-52">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($search !== '' || $categoria !== '')
        <div class="mb-4">
            <button type="button" wire:click="clearFilters" class="ui-btn-secondary !px-4 !py-2 text-sm">
                Limpiar filtros
            </button>
        </div>
    @endif

    @if ($productos->isEmpty())
        <div class="ui-card flex flex-col items-center justify-center gap-4 px-6 py-20 text-center">
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
                <div class="ui-card group flex flex-col overflow-hidden">
                    <a href="{{ route('tienda.producto', $producto->id) }}" wire:navigate class="block aspect-square overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                        @if ($producto->imagen)
                            <img src="{{ asset('storage/'.$producto->imagen) }}" alt="{{ $producto->nombre }}" class="size-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex size-full items-center justify-center text-zinc-300 dark:text-zinc-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 8.25h.008v.008H18V8.25zm3 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        @endif
                    </a>

                    <div class="flex flex-1 flex-col p-4">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-mono text-xs text-zinc-400 dark:text-zinc-500">{{ $producto->codigo }}</span>
                            @if ($producto->stock > 0)
                                <span class="ui-badge-success">En stock</span>
                            @else
                                <span class="ui-badge-danger">Agotado</span>
                            @endif
                        </div>

                        <a href="{{ route('tienda.producto', $producto->id) }}" wire:navigate class="mt-2 line-clamp-2 font-semibold text-zinc-800 hover:text-indigo-600 dark:text-zinc-100 dark:hover:text-indigo-400">
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
