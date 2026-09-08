<x-layouts::app :title="$producto->exists ? __('Editar Producto') : __('Nuevo Producto')">
    <div class="mx-auto max-w-3xl p-6">
        <div class="mb-8">
            <h1 class="ui-title">{{ $producto->exists ? 'Editar Producto' : 'Nuevo Producto' }}</h1>
            <p class="ui-subtitle">{{ $producto->exists ? 'Modifica los datos del producto' : 'Registra un nuevo producto en el catálogo' }}</p>
        </div>

        <form action="{{ $producto->exists ? route('productos.update', $producto->id) : route('productos.store') }}" method="POST" enctype="multipart/form-data" class="ui-card p-8">
            @csrf
            @if ($producto->exists)
                @method('PUT')
            @endif

            <div class="grid gap-6">
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="nombre" class="ui-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}" required maxlength="100" autofocus placeholder="Nombre del producto" class="ui-input">
                        @error('nombre')
                            <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="codigo" class="ui-label">Código</label>
                        <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $producto->codigo ?? '') }}" required maxlength="16" placeholder="PROD-001" class="ui-input font-mono">
                        @error('codigo')
                            <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="descripcion" class="ui-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" placeholder="Descripción opcional del producto" class="ui-input resize-none">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
                    @error('descripcion')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-3">
                    <div>
                        <label for="precio" class="ui-label">Precio</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400 dark:text-zinc-500">$</span>
                            <input type="number" name="precio" id="precio" value="{{ old('precio', $producto->precio ?? '') }}" required min="0" step="0.01" placeholder="0.00" class="ui-input !pl-8">
                        </div>
                        @error('precio')
                            <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="ui-label">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $producto->stock ?? 0) }}" required min="0" step="1" placeholder="0" class="ui-input">
                        @error('stock')
                            <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="activo" class="ui-label">Estado</label>
                        <select name="activo" id="activo" class="ui-input cursor-pointer">
                            <option value="1" {{ old('activo', $producto->activo ?? 1) ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !old('activo', $producto->activo ?? 1) ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('activo')
                            <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="imagen" class="ui-label">Imagen del producto</label>
                    <div class="flex items-start gap-4">
                        <div class="flex shrink-0">
                            @if ($producto->exists && $producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="size-24 rounded-xl object-cover ring-1 ring-zinc-200 dark:ring-zinc-700">
                            @else
                                <div class="flex size-24 items-center justify-center rounded-xl bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="w-full">
                            <input type="file" name="imagen" id="imagen" accept="image/*" class="ui-input cursor-pointer file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-600 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-white hover:file:bg-emerald-700">
                            <p class="ui-note">Formatos permitidos: JPG, JPEG, PNG, WEBP. Máximo 2MB.</p>
                            @error('imagen')
                                <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="ui-label">Categorías</label>
                    <div class="grid gap-3 sm:grid-cols-2">
                        @forelse ($categorias as $categoria)
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 transition-colors hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800/60 dark:hover:bg-zinc-800">
                                <input type="checkbox" name="categorias[]" value="{{ $categoria->id }}"
                                    @if (in_array($categoria->id, old('categorias', $producto->exists ? $producto->categorias()->pluck('categorias.id')->toArray() : []))) checked @endif
                                    class="size-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 dark:border-zinc-600">
                                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ $categoria->nombre }}</span>
                            </label>
                        @empty
                            <p class="ui-note col-span-full">No hay categorías disponibles. Crea una <a href="{{ route('categorias.create') }}" class="font-medium text-indigo-600 underline hover:text-indigo-500 dark:text-indigo-400">nueva categoría</a> primero.</p>
                        @endforelse
                    </div>
                    @error('categorias')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-zinc-200 pt-6 dark:border-zinc-700">
                    <a href="{{ route('productos.index') }}" class="ui-btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="ui-btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $producto->exists ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts::app>