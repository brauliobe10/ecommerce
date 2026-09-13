<div>
    <div class="mb-8">
        <h1 class="ui-title">Registrar Venta</h1>
        <p class="ui-subtitle">Selecciona los productos, las cantidades y registra la venta</p>
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

    <form wire:submit="store" class="ui-card p-8">
        <div class="grid gap-6">
            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <label for="cliente_id" class="ui-label">Cliente</label>
                    <select wire:model="cliente_id" id="cliente_id" class="ui-input cursor-pointer">
                        <option value="">Cliente general</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="metodo_pago" class="ui-label">Método de pago</label>
                    <select wire:model="metodo_pago" id="metodo_pago" class="ui-input cursor-pointer">
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                    @error('metodo_pago')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="estado" class="ui-label">Estado</label>
                    <input type="text" id="estado" value="Completada" disabled class="ui-input cursor-not-allowed opacity-70">
                </div>
            </div>

            <div class="border-t border-zinc-200 pt-6 dark:border-zinc-700">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-indigo-800 dark:text-indigo-300">Productos</h2>
                    <button type="button" wire:click="addItem" class="ui-btn-secondary !px-4 !py-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Agregar producto
                    </button>
                </div>

                @if ($productos->isEmpty())
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-6 text-center dark:border-zinc-700 dark:bg-zinc-800/60">
                        <p class="text-sm text-zinc-600 dark:text-zinc-300">No hay productos activos disponibles para vender.</p>
                        <a href="{{ route('productos.create') }}" class="mt-2 inline-block text-sm font-medium text-indigo-600 underline hover:text-indigo-500 dark:text-indigo-400">Crear un producto</a>
                    </div>
                @else
                    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800/60">
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Producto</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Cantidad</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Subtotal</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $index => $item)
                                    @php $producto = $productos->firstWhere('id', (int) $item['producto_id']); @endphp
                                    <tr class="border-t border-zinc-100 dark:border-zinc-800/60">
                                        <td class="px-4 py-3 align-middle">
                                            <select wire:model="items.{{ $index }}.producto_id" class="ui-input cursor-pointer">
                                                <option value="">Selecciona un producto...</option>
                                                @foreach ($productos as $productoOption)
                                                    <option value="{{ $productoOption->id }}" @disabled($productoOption->stock <= 0)>
                                                        {{ $productoOption->nombre }} — ${{ number_format($productoOption->precio, 2) }} (stock: {{ $productoOption->stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('items.'.$index.'.producto_id')
                                                <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input
                                                type="number"
                                                min="1"
                                                step="1"
                                                wire:model="items.{{ $index }}.cantidad"
                                                class="ui-input !w-28 text-center"
                                                aria-label="Cantidad"
                                            >
                                            @error('items.'.$index.'.cantidad')
                                                <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="px-4 py-3 text-right align-middle font-semibold tabular-nums text-zinc-700 dark:text-zinc-200">
                                            @if ($producto)
                                                ${{ number_format($producto->precio * max((int) $item['cantidad'] ?: 0, 0), 2) }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center align-middle">
                                            <button type="button" wire:click="removeItem({{ $item['key'] }})" class="ui-btn-danger !px-2.5 !py-1.5" title="Quitar producto">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                            Sin productos por registrar. Haz clic en "Agregar producto".
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-4">
                        <div>
                            @error('items')
                                <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center gap-6 sm:gap-10">
                            <div class="text-right">
                                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total a cobrar</p>
                                <p class="mt-1 text-3xl font-bold tabular-nums text-indigo-700 dark:text-indigo-400">${{ number_format($this->total, 2) }}</p>
                            </div>
                            <button type="submit" class="ui-btn-success !px-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Registrar venta
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>