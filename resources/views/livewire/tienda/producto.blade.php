<div>
    <nav class="mb-6 flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
        <a href="{{ route('home') }}" wire:navigate class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Catálogo</a>
        <span>/</span>
        <span class="truncate text-zinc-700 dark:text-zinc-200">{{ $nombre }}</span>
    </nav>

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

    <div class="grid gap-8 lg:grid-cols-2">
        <div class="ui-card overflow-hidden">
            <div class="aspect-square w-full bg-zinc-100 dark:bg-zinc-800">
                @if ($imagen)
                    <img src="{{ asset('storage/'.$imagen) }}" alt="{{ $nombre }}" class="size-full object-cover">
                @else
                    <div class="flex size-full items-center justify-center text-zinc-300 dark:text-zinc-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 8.25h.008v.008H18V8.25zm3 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col">
            <span class="font-mono text-xs text-zinc-400 dark:text-zinc-500">{{ $codigo }}</span>
            <h1 class="mt-1 text-3xl font-bold text-zinc-900 dark:text-white">{{ $nombre }}</h1>

            <div class="mt-3 flex items-center gap-3">
                @if ($stock > 0)
                    <span class="ui-badge-success">En stock ({{ $stock }})</span>
                @else
                    <span class="ui-badge-danger">Agotado</span>
                @endif
            </div>

            <p class="mt-4 text-3xl font-bold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($precio, 2) }}</p>

            @if ($descripcion !== '')
                <p class="mt-4 whitespace-pre-line text-zinc-600 dark:text-zinc-300">{{ $descripcion }}</p>
            @endif

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="w-32">
                    <label for="cantidad" class="ui-label">Cantidad</label>
                    <input
                        type="number"
                        id="cantidad"
                        min="1"
                        max="{{ max($stock, 1) }}"
                        wire:model="cantidad"
                        @disabled($stock <= 0)
                        class="ui-input text-center disabled:cursor-not-allowed disabled:opacity-50"
                    >
                    @error('cantidad')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <button
                    type="button"
                    wire:click="addToCart"
                    @disabled($stock <= 0)
                    class="ui-btn-success flex-1 justify-center sm:flex-none disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                    Agregar al carrito
                </button>

                <a href="{{ route('home') }}" wire:navigate class="ui-btn-secondary justify-center">Seguir comprando</a>
            </div>
        </div>
    </div>
</div>
