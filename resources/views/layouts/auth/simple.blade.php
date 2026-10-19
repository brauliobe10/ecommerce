<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-bg text-text-primary antialiased">
        <div class="flex min-h-svh">
            <aside class="relative hidden w-1/2 flex-col justify-between overflow-hidden p-10 lg:flex">
                <div class="absolute inset-0 bg-navy" aria-hidden="true"></div>
                <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                    <div class="ui-orb -left-16 top-10 size-72 bg-white/25"></div>
                    <div class="ui-orb -right-10 bottom-0 size-80 bg-accent/25"></div>
                    <div class="ui-orb left-1/3 top-1/2 size-64 bg-arena/70"></div>
                </div>

                <div class="relative flex items-center gap-2 text-white">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-white/15 backdrop-blur-xl">
                        <x-app-logo-icon class="size-6 fill-current text-white" />
                    </span>
                    <span class="text-lg font-bold">{{ config('app.name', 'KodeTech') }}</span>
                </div>

                <div class="relative text-white">
                    <h2 class="text-3xl font-extrabold leading-tight">
                        Tu tienda, más simple<br>y más colorida.
                    </h2>
                    <p class="mt-3 max-w-sm text-white/80">
                        Gestioná productos, clientes, ventas y pedidos desde un solo panel, rápido y claro.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-sm font-medium backdrop-blur-xl">
                            <span class="size-2 rounded-full bg-accent"></span> Ventas en tiempo real
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-sm font-medium backdrop-blur-xl">
                            <span class="size-2 rounded-full bg-[#5F7050]"></span> Catálogo siempre disponible
                        </span>
                    </div>
                </div>

                <p class="relative text-xs text-white/60">© {{ date('Y') }} {{ config('app.name', 'KodeTech') }}. Todos los derechos reservados.</p>
            </aside>

            <main class="flex w-full items-center justify-center bg-bg p-6 lg:w-1/2 md:p-10">
                <div class="flex w-full max-w-sm flex-col gap-6">
                    <a href="{{ route('home') }}" class="flex flex-col items-center gap-3 font-medium lg:hidden" wire:navigate>
                        <span class="flex size-11 items-center justify-center rounded-xl bg-accent text-navy shadow-[0_10px_22px_-10px_rgba(199,167,108,0.7)]">
<x-app-logo-icon class="size-6 fill-current text-navy" />
                        </span>
                        <span class="text-base font-bold text-text-primary">{{ config('app.name', 'KodeTech') }}</span>
                    </a>

                    <div class="flex flex-col gap-6">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
