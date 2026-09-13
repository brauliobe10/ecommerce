<div>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="ui-title">Clientes</h1>
            <p class="ui-subtitle">Personas registradas para asociar sus compras</p>
        </div>
        <a href="{{ route('clientes.create') }}" class="ui-btn-success shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Nuevo Cliente
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
            <flux:input
                wire:model.live.debounce.300ms="search"
                icon="magnifying-glass"
                clearable
                placeholder="Buscar por nombre, correo o teléfono..."
                autocomplete="off"
                spellcheck="false"
                class="w-full sm:w-80"
            />
        </div>

        <p class="text-sm text-zinc-500 dark:text-zinc-400">
            Mostrando
            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $clientes->firstItem() ?? 0 }}</span> –
            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $clientes->lastItem() ?? 0 }}</span>
            de
            <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $clientes->total() }}</span>
        </p>
    </div>

    <div class="ui-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th scope="col" class="ui-th text-left">ID</th>
                        <th scope="col" class="ui-th text-left">Nombre</th>
                        <th scope="col" class="ui-th text-left">Correo</th>
                        <th scope="col" class="ui-th text-center">Teléfono</th>
                        <th scope="col" class="ui-th text-center">Compras</th>
                        <th scope="col" class="ui-th text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clientes as $cliente)
                        <tr class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="ui-td whitespace-nowrap font-mono text-zinc-400 dark:text-zinc-500">{{ $cliente->id }}</td>
                            <td class="ui-td">
                                <span class="block max-w-xs truncate font-medium text-indigo-700 dark:text-indigo-400">{{ $cliente->nombre }}</span>
                            </td>
                            <td class="ui-td">
                                <span class="block max-w-xs truncate" title="{{ $cliente->email }}">{{ $cliente->email ?? '-' }}</span>
                            </td>
                            <td class="ui-td text-center">
                                <span class="whitespace-nowrap font-mono">{{ $cliente->telefono ?? '-' }}</span>
                            </td>
                            <td class="ui-td text-center">
                                <span class="ui-badge-info whitespace-nowrap">{{ $cliente->ventas_count }} ventas</span>
                            </td>
                            <td class="ui-td text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" title="Editar" class="ui-btn-edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar al cliente {{ $cliente->nombre }}?')">
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
                            <td colspan="6">
                                <div class="flex flex-col items-center justify-center gap-4 px-6 py-20 text-center">
                                    <div class="ui-empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-zinc-700 dark:text-zinc-200">No hay clientes registrados</p>
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Registra tu primer cliente para asociarlo a sus compras.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($clientes->hasPages())
        <div class="mt-6">
            {{ $clientes->links() }}
        </div>
    @endif
</div>