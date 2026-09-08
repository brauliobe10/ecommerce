<x-layouts::app :title="$usuario->exists ? __('Editar Usuario') : __('Nuevo Usuario')">
    <div class="mx-auto max-w-2xl p-6">
        <div class="mb-8">
            <h1 class="ui-title">{{ $usuario->exists ? 'Editar Usuario' : 'Nuevo Usuario' }}</h1>
            <p class="ui-subtitle">{{ $usuario->exists ? 'Modifica los datos del usuario' : 'Crea un nuevo usuario en el sistema' }}</p>
        </div>

        <form action="{{ $usuario->exists ? route('usuarios.update', $usuario->id) : route('usuarios.store') }}" method="POST" class="ui-card p-8">
            @csrf
            @if ($usuario->exists)
                @method('PUT')
            @endif

            <div class="grid gap-6">
                <div>
                    <label for="name" class="ui-label">Nombre</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $usuario->name ?? '') }}" required autofocus placeholder="Nombre completo" class="ui-input">
                    @error('name')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="ui-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $usuario->email ?? '') }}" required placeholder="usuario@ejemplo.com" class="ui-input">
                    @error('email')
                        <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="password" class="ui-label">Contraseña</label>
                        <input type="password" name="password" id="password" placeholder="{{ $usuario->exists ? 'Dejar en blanco' : '••••••••' }}" {{ $usuario->exists ? '' : 'required' }} class="ui-input">
                        @error('password')
                            <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="ui-label">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ $usuario->exists ? 'Dejar en blanco' : '••••••••' }}" {{ $usuario->exists ? '' : 'required' }} class="ui-input">
                        @error('password_confirmation')
                            <span class="ui-note text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if ($usuario->exists)
                    <p class="ui-note -mt-2">Deja la contraseña en blanco si no deseas cambiarla.</p>
                @endif

                <div class="flex items-center justify-end gap-3 border-t border-zinc-200 pt-6 dark:border-zinc-700">
                    <a href="{{ route('usuarios.index') }}" class="ui-btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="ui-btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $usuario->exists ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts::app>