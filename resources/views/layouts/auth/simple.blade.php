<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-bg text-text-primary antialiased">
        <div class="flex min-h-svh">
            <aside class="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-navy p-10 lg:flex">
                <div class="relative flex items-center gap-2 text-white">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-white/10">
                        <x-app-logo-icon class="size-6 fill-current text-white" />
                    </span>
                    <span class="text-lg font-bold">{{ config('app.name', 'KodeTech') }}</span>
                </div>

                <div class="relative text-white">
                    <h2 class="text-3xl font-extrabold leading-tight">
                        Tu tienda, más simple<br>y más clara.
                    </h2>
                    <p class="mt-3 max-w-sm text-slate-300">
                        Gestiona productos, clientes, ventas y pedidos desde un solo panel, rápido y claro.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <span class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium">
                            <span class="size-2 rounded-full bg-accent"></span> Ventas en tiempo real
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium">
                            <span class="size-2 rounded-full bg-emerald-400"></span> Catálogo siempre disponible
                        </span>
                    </div>
                </div>

                <p class="relative text-xs text-slate-400">© {{ date('Y') }} {{ config('app.name', 'KodeTech') }}. Todos los derechos reservados.</p>
            </aside>

            <main class="flex w-full items-center justify-center bg-bg p-6 md:p-10 lg:w-1/2">
                <div class="flex w-full max-w-sm flex-col gap-6">
                    <a href="{{ route('home') }}" class="flex flex-col items-center gap-3 font-medium lg:hidden" wire:navigate>
                        <span class="flex size-11 items-center justify-center rounded-lg bg-accent text-navy">
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
