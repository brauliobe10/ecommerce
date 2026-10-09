<div x-data="{ open: false }" @abrir-carrito.window="open = true">
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
            class="absolute right-0 top-0 flex h-full w-full flex-col border-l border-white/40 bg-white/80 shadow-xl backdrop-blur-2xl sm:max-w-xl dark:border-white/10 dark:bg-zinc-950/80"
        >
            <div class="flex shrink-0 items-center justify-between border-b border-white/40 px-6 py-4 dark:border-white/10">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-semibold leading-tight text-zinc-900 dark:text-white">Tu carrito</h2>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            @if ($this->cantidad > 0)
                                {{ $this->cantidad }} {{ $this->cantidad === 1 ? 'artículo' : 'artículos' }}
                            @else
                                Sin artículos
                            @endif
                        </p>
                    </div>
                </div>
                <button type="button" @click="open = false" class="rounded-lg p-1.5 text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-700 dark:hover:bg-zinc-800 dark:hover:text-zinc-200" aria-label="Cerrar carrito">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 min-h-0 space-y-3 overflow-y-auto overscroll-contain px-6 pt-5 pb-8">
                @forelse ($items as $item)
                    @php($stock = $item['stock'] ?? null)
                    <div class="group relative flex gap-4 rounded-2xl border border-zinc-100 bg-white/70 p-4 shadow-sm transition hover:border-indigo-200 hover:shadow dark:border-zinc-800 dark:bg-zinc-900/40 dark:hover:border-indigo-500/30">
                        <div class="size-24 shrink-0 overflow-hidden rounded-xl bg-zinc-100 ring-1 ring-zinc-200/70 dark:bg-zinc-800 dark:ring-zinc-700/70">
                            @if ($item['imagen'])
                                <img src="{{ asset('storage/'.$item['imagen']) }}" alt="{{ $item['nombre'] }}" class="size-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <div class="flex size-full items-center justify-center text-zinc-300 dark:text-zinc-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 8.25h.008v.008H18V8.25zm3 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex min-w-0 flex-1 flex-col">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <span class="inline-flex rounded-md bg-zinc-100 px-1.5 py-0.5 font-mono text-[10px] font-medium text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">{{ $item['codigo'] }}</span>
                                    <p class="mt-1 line-clamp-2 text-base font-semibold text-zinc-800 dark:text-zinc-100">{{ $item['nombre'] }}</p>
                                </div>
                                <button type="button" wire:click="remove({{ $item['producto_id'] }})" class="shrink-0 rounded-lg p-1 text-zinc-400 transition hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/10 dark:hover:text-red-400" aria-label="Quitar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>

                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                ${{ number_format($item['precio'], 2) }} c/u
                                @if ($stock !== null)
                                    <span class="text-zinc-400 dark:text-zinc-500">· Stock: {{ $stock }}</span>
                                @endif
                            </p>

                            <div class="mt-auto flex items-end justify-between pt-2">
                                <div class="flex items-center gap-1 rounded-xl border border-zinc-200 bg-white p-0.5 dark:border-zinc-700 dark:bg-zinc-900/60">
                                    <button
                                        type="button"
                                        wire:click="decrement({{ $item['producto_id'] }})"
                                        class="flex size-8 items-center justify-center rounded-lg text-zinc-600 transition hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800"
                                        aria-label="Quitar una unidad"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>
                                    </button>
                                    <span class="w-9 text-center text-sm font-semibold tabular-nums text-zinc-800 dark:text-zinc-100">{{ $item['cantidad'] }}</span>
                                    <button
                                        type="button"
                                        wire:click="increment({{ $item['producto_id'] }})"
                                        @disabled($stock !== null && $item['cantidad'] >= $stock)
                                        class="flex size-8 items-center justify-center rounded-lg text-zinc-600 transition hover:bg-zinc-100 disabled:cursor-not-allowed disabled:opacity-40 dark:text-zinc-300 dark:hover:bg-zinc-800"
                                        aria-label="Agregar una unidad"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                    </button>
                                </div>

                                <div class="text-right">
                                    <span class="block text-[10px] font-medium uppercase tracking-wide text-zinc-400 dark:text-zinc-500">Subtotal</span>
                                    <span class="text-base font-bold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                                </div>
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
                        <a href="{{ route('home') }}#catalogo" wire:navigate class="ui-btn-secondary !px-4 !py-2 text-sm">Ver catálogo</a>
                    </div>
                @endforelse
            </div>

            @if ($this->cantidad > 0)
                <div class="shrink-0 border-t border-white/40 px-6 py-5 dark:border-white/10">
                    <dl class="space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <dt class="text-zinc-500 dark:text-zinc-400">Subtotal ({{ $this->cantidad }} {{ $this->cantidad === 1 ? 'producto' : 'productos' }})</dt>
                            <dd class="tabular-nums font-medium text-zinc-700 dark:text-zinc-200">${{ number_format($this->subtotal, 2) }}</dd>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <dt class="text-zinc-500 dark:text-zinc-400">Envío</dt>
                            <dd class="text-xs font-medium text-emerald-600 dark:text-emerald-400">A coordinar</dd>
                        </div>
                    </dl>

                    <div class="mt-3 flex items-center justify-between border-t border-zinc-200 pt-3 dark:border-zinc-800">
                        <span class="font-semibold text-zinc-800 dark:text-zinc-100">Total</span>
                        <span class="text-2xl font-bold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($this->subtotal, 2) }}</span>
                    </div>

                    <div class="mt-4 space-y-2">
                        <a href="{{ route('tienda.checkout') }}" wire:navigate class="ui-btn-success w-full justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Confirmar pedido
                        </a>
                        <a href="{{ route('tienda.carrito') }}" wire:navigate @click="open = false" class="ui-btn-secondary w-full justify-center">
                            Ver carrito completo
                        </a>
                    </div>

                    <button type="button" wire:click="clear" class="mt-3 w-full text-center text-xs text-zinc-400 transition hover:text-red-600 dark:hover:text-red-400">
                        Vaciar carrito
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
