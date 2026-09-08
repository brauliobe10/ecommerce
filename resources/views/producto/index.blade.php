<x-layouts::app :title="__('Productos')">
    <div class="mx-auto max-w-7xl p-6">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="ui-title">Productos</h1>
                <p class="ui-subtitle">Catálogo de productos del comercio</p>
            </div>
            <a href="{{ route('productos.create') }}" class="ui-btn-success shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nuevo Producto
            </a>
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

        <div class="ui-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th scope="col" class="ui-th">ID</th>
                            <th scope="col" class="ui-th">Imagen</th>
                            <th scope="col" class="ui-th">Nombre</th>
                            <th scope="col" class="ui-th">Código</th>
                            <th scope="col" class="ui-th text-right">Precio</th>
                            <th scope="col" class="ui-th text-center">Stock</th>
                            <th scope="col" class="ui-th text-center">Estado</th>
                            <th scope="col" class="ui-th text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                            <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="ui-td font-mono text-zinc-400 dark:text-zinc-500">{{ $producto->id }}</td>
                                <td class="ui-td">
                                    <div class="flex items-center justify-center">
                                        @if ($producto->imagen)
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="size-12 rounded-xl object-cover ring-1 ring-zinc-200 dark:ring-zinc-700">
                                        @else
                                            <div class="flex size-12 items-center justify-center rounded-xl bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="ui-td font-medium text-indigo-700 dark:text-indigo-400">{{ $producto->nombre }}</td>
                                <td class="ui-td font-mono">{{ $producto->codigo }}</td>
                                <td class="ui-td text-right font-semibold text-indigo-700 dark:text-indigo-400">${{ number_format($producto->precio, 2) }}</td>
                                <td class="ui-td">
                                    <div class="flex justify-center">
                                        <span class="ui-badge-info">{{ $producto->stock }}</span>
                                    </div>
                                </td>
                                <td class="ui-td">
                                    <div class="flex justify-center">
                                        <form action="{{ route('productos.toggleStatus', $producto->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="{{ $producto->activo ? 'ui-badge-success' : 'ui-badge-danger' }} cursor-pointer transition-transform hover:scale-105">
                                                <span class="size-1.5 rounded-full {{ $producto->activo ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                                {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="ui-td">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('productos.edit', $producto->id) }}" class="ui-btn-edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            Editar
                                        </a>
                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar el producto {{ $producto->nombre }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ui-btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center text-zinc-500 dark:text-zinc-400">
                                    No hay productos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($productos->hasPages())
            <div class="mt-6">
                {{ $productos->links() }}
            </div>
        @endif
    </div>
</x-layouts::app>