<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $categoria->exists ? 'Editar' : 'Crear' }} Categoría</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            {{ $categoria->exists ? 'Editar Categoría' : 'Nueva Categoría' }}
        </h1>

        <form action="{{ $categoria->exists ? route('categorias.update', $categoria) : route('categorias.store') }}" method="POST">
            @csrf
            @if($categoria->exists)
            @method('PUT')
            @endif

            <!-- Campo Nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" id="nombre"
                    value="{{ old('nombre', $categoria->nombre ?? '') }}"
                    class="w-full border-gray-300 rounded-md border p-2 focus:ring-2 focus:ring-blue-500" required>
                @error('nombre')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Campo Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full border-gray-300 rounded-md border p-2 focus:ring-2 focus:ring-blue-500">{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>
                @error('descripcion')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Campo Estado -->
            <div class="mb-6">
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="estado" id="estado" class="w-full border-gray-300 rounded-md border p-2 focus:ring-2 focus:ring-blue-500">
                    <option value="activo" {{ old('estado', $categoria->estado ?? 'activo') === 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado', $categoria->estado ?? '') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('categorias.index') }}" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    {{ $categoria->exists  ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
</body>

</html>