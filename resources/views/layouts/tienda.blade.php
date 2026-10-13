<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
        <div class="pointer-events-none fixed inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(79,70,229,0.06),_transparent_55%)] dark:bg-[radial-gradient(circle_at_top,_rgba(99,102,241,0.10),_transparent_55%)]"></div>
        </div>

        <div class="relative" x-data="{ abrirCarrito: false, menuAbierto: false }">
            @php
                $navItems = [
                    ['label' => 'Inicio', 'href' => route('home'), 'navigate' => true, 'active' => request()->routeIs('home')],
                    ['label' => 'Catálogo', 'href' => route('tienda.catalogo'), 'navigate' => true, 'active' => request()->routeIs('tienda.catalogo')],
                    ['label' => 'Sobre nosotros', 'href' => route('tienda.sobre'), 'navigate' => true, 'active' => request()->routeIs('tienda.sobre')],
                    ['label' => 'Contacto', 'href' => route('tienda.contacto'), 'navigate' => true, 'active' => request()->routeIs('tienda.contacto')],
                ];
            @endphp

            <header class="sticky top-0 z-40 border-b border-zinc-200 bg-white/85 backdrop-blur-xl dark:border-zinc-800 dark:bg-zinc-950/80">
                <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-6">
                        <x-app-logo href="{{ route('home') }}" wire:navigate />
                        <nav class="hidden items-center gap-1 md:flex">
                            @foreach ($navItems as $item)
                                <a
                                    href="{{ $item['href'] }}"
                                    @if ($item['navigate']) wire:navigate @endif
                                    @class([
                                        'rounded-lg px-3 py-2 text-sm font-medium transition',
                                        'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400' => $item['active'],
                                        'text-zinc-600 hover:bg-white/80 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800/80 dark:hover:text-white' => ! $item['active'],
                                    ])
                                >
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" wire:navigate class="hidden ui-btn-secondary !px-4 !py-2 text-sm sm:inline-flex">
                                Panel
                            </a>
                        @else
                            <a href="{{ route('login') }}" wire:navigate class="hidden text-sm font-medium text-zinc-500 transition hover:text-indigo-600 dark:text-zinc-400 dark:hover:text-indigo-400 md:block">
                                Ingresar
                            </a>
                        @endauth

                        <livewire:tienda.carrito-boton />

                        <button
                            type="button"
                            @click="menuAbierto = ! menuAbierto"
                            class="inline-flex size-10 items-center justify-center rounded-xl border border-zinc-200 bg-white text-zinc-600 transition hover:text-indigo-600 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:text-indigo-400 md:hidden"
                            aria-label="Abrir menú"
                        >
                            <svg x-show="! menuAbierto" xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <svg x-show="menuAbierto" x-cloak xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div x-show="menuAbierto" x-cloak @click.away="menuAbierto = false" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="-translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="border-t border-zinc-200 bg-white/95 px-4 py-3 backdrop-blur-xl dark:border-zinc-800 dark:bg-zinc-950/95 md:hidden">
                    <nav class="flex flex-col gap-1">
                        @foreach ($navItems as $item)
                            <a
                                href="{{ $item['href'] }}"
                                @if ($item['navigate']) wire:navigate @endif
                                @click="menuAbierto = false"
                                @class([
                                    'rounded-lg px-3 py-2.5 text-sm font-medium transition',
                                    'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400' => $item['active'],
                                    'text-zinc-600 hover:bg-white/80 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800/80 dark:hover:text-white' => ! $item['active'],
                                ])
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach

                        @auth
                            <a href="{{ route('dashboard') }}" wire:navigate @click="menuAbierto = false" class="rounded-lg px-3 py-2.5 text-sm font-medium text-zinc-600 transition hover:bg-white/80 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800/80 dark:hover:text-white">
                                Panel
                            </a>
                        @else
                            <a href="{{ route('login') }}" wire:navigate @click="menuAbierto = false" class="rounded-lg px-3 py-2.5 text-sm font-medium text-zinc-600 transition hover:bg-white/80 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800/80 dark:hover:text-white">
                                Ingresar
                            </a>
                        @endauth
                    </nav>
                </div>
            </header>

            <main>
                {{ $slot }}
            </main>

            <footer class="mt-16 border-t border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">
                <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-4 py-10 text-center sm:flex-row sm:text-left sm:px-6 lg:px-8">
                    <div>
                        <p class="text-lg font-semibold text-zinc-900 dark:text-white">{{ config('app.name', 'KodeTech') }}</p>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Tu tienda de confianza. Productos seleccionados y atención personalizada.</p>
                    </div>

                    <nav class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm font-medium text-zinc-600 dark:text-zinc-300">
                        <a href="{{ route('home') }}" wire:navigate class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Inicio</a>
                        <a href="{{ route('tienda.catalogo') }}" wire:navigate class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Catálogo</a>
                        <a href="{{ route('tienda.sobre') }}" wire:navigate class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Sobre nosotros</a>
                        <a href="{{ route('tienda.contacto') }}" wire:navigate class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Contacto</a>
                    </nav>
                </div>
            </footer>

            <livewire:tienda.carrito />
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
