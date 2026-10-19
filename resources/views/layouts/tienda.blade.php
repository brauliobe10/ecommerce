<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-bg text-text-primary">
        <div class="pointer-events-none fixed inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(184,163,141,0.04),_transparent_60%)]"></div>
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

            <header class="sticky top-0 z-40 border-b border-white/10 bg-navy/95 backdrop-blur-xl">
                <div class="ui-gradient-brand h-1 w-full"></div>
                <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-6">
                        <x-app-logo href="{{ route('home') }}" wire:navigate />
                        <nav class="hidden items-center gap-1 md:flex">
                            @foreach ($navItems as $item)
                                <a
                                    href="{{ $item['href'] }}"
                                    @if ($item['navigate']) wire:navigate @endif
                                    @class([
                                        'rounded-lg px-3 py-2 text-sm font-medium transition-colors duration-150',
                                        'bg-accent text-navy shadow-sm' => $item['active'],
                                        'text-arena hover:bg-white/5 hover:text-white' => ! $item['active'],
                                    ])
                                >
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" wire:navigate class="hidden inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-4 py-2 text-sm font-medium text-white transition-all duration-150 hover:-translate-y-0.5 hover:bg-white/10 sm:inline-flex">
                                Panel
                            </a>
                        @else
                            <a href="{{ route('login') }}" wire:navigate class="hidden text-sm font-medium text-arena transition-colors hover:text-white md:block">
                                Ingresar
                            </a>
                        @endauth

                        <livewire:tienda.carrito-boton />

                        <button
                            type="button"
                            @click="menuAbierto = ! menuAbierto"
                            class="inline-flex size-10 items-center justify-center rounded-xl border border-white/15 bg-white/5 text-arena transition-colors hover:text-white md:hidden"
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

                <div x-show="menuAbierto" x-cloak @click.away="menuAbierto = false" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="-translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="border-t border-white/10 bg-navy/98 px-4 py-3 backdrop-blur-xl md:hidden">
                    <nav class="flex flex-col gap-1">
                        @foreach ($navItems as $item)
                            <a
                                href="{{ $item['href'] }}"
                                @if ($item['navigate']) wire:navigate @endif
                                @click="menuAbierto = false"
                                @class([
                                    'rounded-lg px-3 py-2.5 text-sm font-medium transition-colors duration-150',
                                    'bg-accent text-navy' => $item['active'],
                                    'text-arena hover:bg-white/5 hover:text-white' => ! $item['active'],
                                ])
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach

                        @auth
                            <a href="{{ route('dashboard') }}" wire:navigate @click="menuAbierto = false" class="rounded-lg px-3 py-2.5 text-sm font-medium text-arena transition-colors hover:bg-white/5 hover:text-white">
                                Panel
                            </a>
                        @else
                            <a href="{{ route('login') }}" wire:navigate @click="menuAbierto = false" class="rounded-lg px-3 py-2.5 text-sm font-medium text-arena transition-colors hover:bg-white/5 hover:text-white">
                                Ingresar
                            </a>
                        @endauth
                    </nav>
                </div>
            </header>

            <main>
                {{ $slot }}
            </main>

            <footer class="mt-16 border-t border-white/10 bg-navy">
                <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-4 py-10 text-center sm:flex-row sm:text-left sm:px-6 lg:px-8">
                    <div>
                        <p class="text-lg font-semibold text-white">{{ config('app.name', 'KodeTech') }}</p>
                        <p class="mt-1 text-sm text-zinc-400">Tu tienda de confianza. Productos seleccionados y atención personalizada.</p>
                    </div>

                    <nav class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm font-medium text-zinc-300">
                        <a href="{{ route('home') }}" wire:navigate class="transition-colors hover:text-accent">Inicio</a>
                        <a href="{{ route('tienda.catalogo') }}" wire:navigate class="transition-colors hover:text-accent">Catálogo</a>
                        <a href="{{ route('tienda.sobre') }}" wire:navigate class="transition-colors hover:text-accent">Sobre nosotros</a>
                        <a href="{{ route('tienda.contacto') }}" wire:navigate class="transition-colors hover:text-accent">Contacto</a>
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
