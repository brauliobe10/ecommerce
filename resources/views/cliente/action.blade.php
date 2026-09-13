<x-layouts::app :title="$cliente->exists ? __('Editar Cliente') : __('Nuevo Cliente')">
    <div class="mx-auto max-w-2xl p-6">
        <div class="mb-8">
            <h1 class="ui-title">{{ $cliente->exists ? 'Editar Cliente' : 'Nuevo Cliente' }}</h1>
            <p class="ui-subtitle">{{ $cliente->exists ? 'Modifica los datos del cliente' : 'Registra un nuevo cliente del comercio' }}</p>
        </div>

        <form action="{{ $cliente->exists ? route('clientes.update', $cliente->id) : route('clientes.store') }}" method="POST" class="ui-card p-8">
            @csrf
            @if ($cliente->exists)
                @method('PUT')
            @endif

            <div class="grid gap-6">
                <div>
                    <label for="nombre" class="ui-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre ?? '') }}" required maxlength="100" autofocus placeholder="Nombre del cliente" class="ui-input">
                    @error('nombre')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="email" class="ui-label">Correo electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $cliente->email ?? '') }}" maxlength="150" placeholder="cliente@example.com" class="ui-input">
                        @error('email')
                            <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="telefono" class="ui-label">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $cliente->telefono ?? '') }}" maxlength="20" placeholder="555-123-4567" class="ui-input">
                        @error('telefono')
                            <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-zinc-200 pt-6 dark:border-zinc-700">
                    <a href="{{ route('clientes.index') }}" class="ui-btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="ui-btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $cliente->exists ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts::app>