<div x-data="{ open: false }" @abrir-carrito.window="open = true">
    <button
        type="button"
        @click="open = true"
        class="relative inline-flex size-10 items-center justify-center rounded-xl border border-zinc-200 bg-white text-zinc-600 transition hover:border-zinc-300 hover:text-indigo-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:text-indigo-400"
        aria-label="Abrir carrito"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
        </svg>
        @if ($this->cantidad > 0)
            <span class="absolute -right-1.5 -top-1.5 flex size-5 items-center justify-center rounded-full bg-indigo-600 text-[10px] font-bold text-white">
                {{ $this->cantidad > 99 ? '99+' : $this->cantidad }}
            </span>
        @endif
    </button>

    <div x-show="open" class="fixed inset-0 z-50" style="display: none;">
        <div
            x-show="open"
            x-transition.opacity
            @click="open = false"
            class="absolute inset-0 bg-zinc-900/40 backdrop-blur-sm"
        ></div>

        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 flex h-full w-full max-w-md flex-col bg-white shadow-xl dark:bg-zinc-950"
        >
            <div class="flex items-center justify-between border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Tu carrito</h2>
                <button type="button" @click="open = false" class="rounded-lg p-1.5 text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-700 dark:hover:bg-zinc-800 dark:hover:text-zinc-200" aria-label="Cerrar carrito">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-5 py-4">
                @forelse ($items as $item)
                    <div class="flex gap-4 border-b border-zinc-100 py-4 last:border-0 dark:border-zinc-800">
                        <div class="size-16 shrink-0 overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800">
                            @if ($item['imagen'])
                                <img src="{{ asset('storage/'.$item['imagen']) }}" alt="{{ $item['nombre'] }}" class="size-full object-cover">
                            @endif
                        </div>

                        <div class="flex min-w-0 flex-1 flex-col">
                            <div class="flex items-start justify-between gap-2">
                                <p class="line-clamp-2 text-sm font-medium text-zinc-800 dark:text-zinc-100">{{ $item['nombre'] }}</p>
                                <button type="button" wire:click="remove({{ $item['producto_id'] }})" class="shrink-0 text-zinc-400 transition hover:text-red-600" aria-label="Quitar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <p class="mt-1 text-sm font-semibold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($item['precio'], 2) }}</p>

                            <div class="mt-auto flex items-center gap-2 pt-2">
                                <button type="button" wire:click="decrement({{ $item['producto_id'] }})" class="flex size-7 items-center justify-center rounded-lg border border-zinc-200 text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>
                                </button>
                                <span class="w-8 text-center text-sm font-semibold tabular-nums text-zinc-800 dark:text-zinc-100">{{ $item['cantidad'] }}</span>
                                <button type="button" wire:click="increment({{ $item['producto_id'] }})" class="flex size-7 items-center justify-center rounded-lg border border-zinc-200 text-zinc-600 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center gap-3 py-20 text-center">
                        <div class="ui-empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </div>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Tu carrito está vacío.</p>
                    </div>
                @endforelse
            </div>

            @if ($this->cantidad > 0)
                <div class="border-t border-zinc-200 px-5 py-4 dark:border-zinc-800">
                    <div class="mb-4 flex items-center justify-between">
                        <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Subtotal</span>
                        <span class="text-2xl font-bold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($this->subtotal, 2) }}</span>
                    </div>
                    <a href="{{ route('tienda.checkout') }}" wire:navigate class="ui-btn-success w-full justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Confirmar pedido
                    </a>
                    <button type="button" wire:click="clear" class="mt-2 w-full text-center text-xs text-zinc-400 transition hover:text-red-600 dark:hover:text-red-400">
                        Vaciar carrito
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
