<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
        <div class="pointer-events-none fixed inset-0 overflow-hidden" aria-hidden="true">
            <div class="ui-orb -left-32 -top-24 size-96 bg-indigo-400/30 dark:bg-indigo-600/20"></div>
            <div class="ui-orb -right-24 top-1/3 size-[28rem] bg-fuchsia-400/25 dark:bg-fuchsia-600/15"></div>
            <div class="ui-orb -bottom-32 left-1/3 size-96 bg-sky-400/20 dark:bg-sky-600/15"></div>
        </div>

        <div class="relative" x-data="{ abrirCarrito: false, menuAbierto: false }">
            @php
                $navItems = [
                    ['label' => 'Inicio', 'href' => route('home'), 'navigate' => true, 'active' => request()->routeIs('home')],
                    ['label' => 'Catálogo', 'href' => route('home').'#catalogo', 'navigate' => false, 'active' => false],
                    ['label' => 'Sobre nosotros', 'href' => route('tienda.sobre'), 'navigate' => true, 'active' => request()->routeIs('tienda.sobre')],
                    ['label' => 'Contacto', 'href' => route('tienda.contacto'), 'navigate' => true, 'active' => request()->routeIs('tienda.contacto')],
                ];
            @endphp
            <div class="relative z-40 bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600 py-2 text-center text-xs font-medium text-white">
                <div class="mx-auto flex max-w-7xl items-center justify-center gap-2 px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <span>Confirmá tu pedido fácil y rápido por <span class="font-bold">WhatsApp</span></span>
                </div>
            </div>

            <header class="sticky top-0 z-40 border-b border-white/40 bg-white/70 backdrop-blur-xl dark:border-white/10 dark:bg-zinc-950/60">
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
                            class="inline-flex size-10 items-center justify-center rounded-xl border border-white/40 bg-white/70 text-zinc-600 transition hover:text-indigo-600 dark:border-white/10 dark:bg-zinc-900/60 dark:text-zinc-300 dark:hover:text-indigo-400 md:hidden"
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

                <div x-show="menuAbierto" x-cloak @click.away="menuAbierto = false" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="-translate-y-2 opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="border-t border-white/40 bg-white/80 px-4 py-3 backdrop-blur-xl dark:border-white/10 dark:bg-zinc-950/80 md:hidden">
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

            <footer class="mt-16 border-t border-white/40 bg-white/60 backdrop-blur-xl dark:border-white/10 dark:bg-zinc-950/60">
                <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-4 py-10 text-center sm:flex-row sm:text-left sm:px-6 lg:px-8">
                    <div>
                        <p class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">{{ config('app.name', 'KodeTech') }}</p>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Tu tienda de confianza. Realiza tu pedido y confírmalo por WhatsApp.</p>
                    </div>

                    @php($whatsapp = preg_replace('/\D+/', '', (string) config('services.whatsapp.number')))
                    @if (filled($whatsapp))
                        <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="ui-btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Escríbenos por WhatsApp
                        </a>
                    @endif
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
