<div>
    <div class="mb-8">
        <h1 class="ui-title">Confirmar pedido</h1>
        <p class="ui-subtitle">Completa tus datos y confirma por WhatsApp</p>
    </div>

    @if ($errors->has('items'))
        <div class="ui-alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
            {{ $errors->first('items') }}
        </div>
    @endif

    <div class="grid gap-8 lg:grid-cols-5">
        <form wire:submit="confirmar" class="ui-card space-y-5 p-6 lg:col-span-3">
            <div>
                <label for="nombre" class="ui-label">Nombre completo</label>
                <input type="text" id="nombre" wire:model="nombre" class="ui-input" autocomplete="name" placeholder="Tu nombre">
                @error('nombre')
                    <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="telefono" class="ui-label">Teléfono / WhatsApp</label>
                    <input type="text" id="telefono" wire:model="telefono" class="ui-input" autocomplete="tel" placeholder="Ej: 3001234567">
                    @error('telefono')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="ui-label">Correo (opcional)</label>
                    <input type="email" id="email" wire:model="email" class="ui-input" autocomplete="email" placeholder="tucorreo@ejemplo.com">
                    @error('email')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="direccion" class="ui-label">Dirección de entrega (opcional)</label>
                <input type="text" id="direccion" wire:model="direccion" class="ui-input" autocomplete="street-address" placeholder="Calle, número, ciudad">
                @error('direccion')
                    <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="notas" class="ui-label">Notas del pedido (opcional)</label>
                <textarea id="notas" wire:model="notas" rows="3" class="ui-input" placeholder="Indicaciones adicionales..."></textarea>
                @error('notas')
                    <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="ui-btn-success w-full justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Confirmar por WhatsApp
            </button>

            <p class="text-center text-xs text-zinc-400 dark:text-zinc-500">
                Se abrirá WhatsApp con el resumen de tu pedido para finalizar la compra.
            </p>
        </form>

        <aside class="ui-card h-fit p-6 lg:col-span-2">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Resumen del pedido</h2>

            <ul class="mt-4 space-y-3">
                @forelse ($items as $item)
                    <li class="flex items-start justify-between gap-3 text-sm">
                        <span class="text-zinc-600 dark:text-zinc-300">
                            <span class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $item['cantidad'] }}x</span>
                            {{ $item['nombre'] }}
                        </span>
                        <span class="whitespace-nowrap tabular-nums text-zinc-700 dark:text-zinc-200">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                    </li>
                @empty
                    <li class="text-sm text-zinc-500 dark:text-zinc-400">Tu carrito está vacío.</li>
                @endforelse
            </ul>

            <div class="mt-5 flex items-center justify-between border-t border-zinc-200 pt-4 dark:border-zinc-800">
                <span class="font-medium text-zinc-600 dark:text-zinc-300">Total</span>
                <span class="text-2xl font-bold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($total, 2) }}</span>
            </div>

            <a href="{{ route('home') }}" wire:navigate class="mt-4 block text-center text-sm text-zinc-500 underline-offset-4 transition hover:text-indigo-600 hover:underline dark:text-zinc-400 dark:hover:text-indigo-400">
                Seguir comprando
            </a>
        </aside>
    </div>
</div>
