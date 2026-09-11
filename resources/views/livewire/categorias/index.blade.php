<div>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="ui-title">Categorías</h1>
            <p class="ui-subtitle">Organiza tus productos en categorías</p>
        </div>
        <a href="{{ route('categorias.create') }}" class="ui-btn-success shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nueva Categoría
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

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-1 flex-wrap items-center gap-3">
            <div class="inline-flex items-center gap-1 rounded-xl bg-zinc-100 p-1 dark:bg-zinc-800">
                @foreach (['' => 'Todas', 'activo' => 'Activas', 'inactivo' => 'Inactivas'] as $value => $label)
                    @php $active = $estado === $value; @endphp
                    <button
                        type="button"
                        wire:click="$set('estado', '{{ $value }}')"
                        class="rounded-lg px-4 py-1.5 text-sm font-medium transition-all {{ $active ? 'bg-white text-indigo-700 shadow-sm dark:bg-zinc-700 dark:text-indigo-400' : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <flux:input
                wire:model.live.debounce.300ms="search"
                icon="magnifying-glass"
                clearable
                placeholder="Buscar por nombre o descripción..."
                autocomplete="off"
                spellcheck="false"
                class="w-full sm:w-80"
            />
        </div>

        <p class="text-sm text-zinc-500 dark:text-zinc-400">
            Mostrando
            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $categorias->firstItem() ?? 0 }}</span> –
            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $categorias->lastItem() ?? 0 }}</span>
            de
            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $categorias->total() }}</span>
        </p>
    </div>

    <div class="ui-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th scope="col" class="ui-th text-left">ID</th>
                        <th scope="col" class="ui-th text-left">Nombre</th>
                        <th scope="col" class="ui-th text-left">Descripción</th>
                        <th scope="col" class="ui-th text-center">Estado</th>
                        <th scope="col" class="ui-th text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="ui-td whitespace-nowrap font-mono text-zinc-400 dark:text-zinc-500">{{ $categoria->id }}</td>
                            <td class="ui-td">
                                <span class="block max-w-xs truncate font-medium text-indigo-700 dark:text-indigo-400">{{ $categoria->nombre }}</span>
                            </td>
                            <td class="ui-td">
                                <span class="block max-w-md truncate" title="{{ $categoria->descripcion }}">{{ $categoria->descripcion ?? '-' }}</span>
                            </td>
                            <td class="ui-td text-center">
                                <div class="flex justify-center">
                                    <form action="{{ route('categorias.toggleStatus', $categoria->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="{{ $categoria->estado === 'activo' ? 'ui-badge-success' : 'ui-badge-danger' }} cursor-pointer whitespace-nowrap transition-transform hover:scale-105">
                                            <span class="size-1.5 rounded-full {{ $categoria->estado === 'activo' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                            {{ ucfirst($categoria->estado) }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="ui-td text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('categorias.edit', $categoria->id) }}" title="Editar" class="ui-btn-edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar la categoría {{ $categoria->nombre }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Eliminar" class="ui-btn-danger">
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
                            <td colspan="5">
                                <div class="flex flex-col items-center justify-center gap-4 px-6 py-20 text-center">
                                    <div class="ui-empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-zinc-700 dark:text-zinc-200">No hay categorías registradas</p>
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Crea tu primera categoría para empezar a organizar tus productos.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($categorias->hasPages())
        <div class="mt-6">
            {{ $categorias->links() }}
        </div>
    @endif
</div>