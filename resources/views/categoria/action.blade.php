<x-layouts::app :title="$categoria->exists ? __('Editar Categoría') : __('Nueva Categoría')">
    <div class="mx-auto max-w-2xl p-6">
        <div class="mb-8">
            <h1 class="ui-title">{{ $categoria->exists ? 'Editar Categoría' : 'Nueva Categoría' }}</h1>
            <p class="ui-subtitle">{{ $categoria->exists ? 'Modifica los datos de la categoría' : 'Crea una nueva categoría de productos' }}</p>
        </div>

        <form action="{{ $categoria->exists ? route('categorias.update', $categoria->id) : route('categorias.store') }}" method="POST" class="ui-card p-8">
            @csrf
            @if ($categoria->exists)
                @method('PUT')
            @endif

            <div class="grid gap-6">
                <div>
                    <label for="nombre" class="ui-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" required maxlength="100" autofocus placeholder="Nombre de la categoría" class="ui-input">
                    @error('nombre')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="descripcion" class="ui-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" maxlength="255" placeholder="Descripción opcional de la categoría" class="ui-input resize-none">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
                    @error('descripcion')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="estado" class="ui-label">Estado</label>
                    <select name="estado" id="estado" class="ui-input cursor-pointer">
                        <option value="activo" {{ old('estado', $categoria->estado ?? 'activo') === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $categoria->estado ?? '') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-zinc-200 pt-6 dark:border-zinc-700">
                    <a href="{{ route('categorias.index') }}" class="ui-btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="ui-btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $categoria->exists ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts::app>