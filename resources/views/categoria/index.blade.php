<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Categorías</h1>
            <a href="{{ route('categorias.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Nueva Categoría
            </a>
        </div>

        @if(session('mensaje'))
        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
            {{ session('mensaje') }}
        </div>
        @endif

        <table class="w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Descripción</th>
                    <th class="p-3 text-center">Productos</th>
                    <th class="p-3 text-center">Estado</th>
                    <th class="p-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorias ?? [] as $cat)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $cat->id }}</td>
                    <td class="p-3 font-semibold">{{ $cat->nombre ?? $cat->name }}</td>
                    <td class="p-3 text-gray-600">{{ $cat->descripcion ?? '-' }}</td>
                    <td class="p-3 text-center">{{ $cat->productos_count ?? 0 }}</td>
                    <td class="p-3 text-center">
                        <form action="{{ route('categorias.toggleStatus', $cat->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="px-2 py-1 text-xs font-bold rounded {{ $cat->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($cat->estado) }}
                            </button>
                        </form>
                    </td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('categorias.edit', $cat->id) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('categorias.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        No hay categorías enviadas a la vista. 
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>