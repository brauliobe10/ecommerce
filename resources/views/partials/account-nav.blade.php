@php
    $enlacesCuenta = [
        ['label' => 'Mi cuenta', 'route' => 'cliente.cuenta', 'active' => request()->routeIs('cliente.cuenta')],
        ['label' => 'Mis pedidos', 'route' => 'cliente.pedidos.index', 'active' => request()->routeIs('cliente.pedidos.*')],
        ['label' => 'Perfil', 'route' => 'profile.edit', 'active' => request()->routeIs('profile.edit')],
        ['label' => 'Seguridad', 'route' => 'security.edit', 'active' => request()->routeIs('security.edit')],
        ['label' => 'Apariencia', 'route' => 'appearance.edit', 'active' => request()->routeIs('appearance.edit')],
    ];
@endphp

<nav class="mb-8 flex items-center gap-1 overflow-x-auto rounded-2xl border border-border bg-surface p-2 text-sm [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
    @foreach ($enlacesCuenta as $enlace)
        <a
            href="{{ route($enlace['route']) }}"
            wire:navigate
            @class([
                'shrink-0 whitespace-nowrap rounded-xl px-3 py-2 font-semibold transition-colors',
                'bg-navy text-white' => $enlace['active'],
                'text-text-secondary hover:bg-surface-muted hover:text-navy dark:hover:text-accent' => ! $enlace['active'],
            ])
        >
            {{ $enlace['label'] }}
        </a>
    @endforeach
</nav>
