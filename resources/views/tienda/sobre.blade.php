<x-layouts::tienda :title="__('Sobre nosotros')">
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="ui-orb -right-20 top-6 size-80 bg-fuchsia-400/30 dark:bg-fuchsia-600/20"></div>
            <div class="ui-orb -left-24 bottom-0 size-96 bg-indigo-400/30 dark:bg-indigo-600/20"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <div class="ui-glass mx-auto max-w-3xl p-8 text-center sm:p-12">
                <span class="ui-badge-info">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                    Sobre nosotros
                </span>

                <h1 class="mt-5 text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                    Conocé
                    <span class="bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600 bg-clip-text text-transparent dark:from-indigo-400 dark:via-violet-400 dark:to-fuchsia-400">
                        {{ config('app.name', 'KodeTech') }}
                    </span>
                </h1>

                <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-300">
                    Somos tu tienda de confianza. Elegí de nuestro catálogo, armá tu carrito y confirmá tu pedido
                    directo por WhatsApp, sin vueltas y en pocos minutos.
                </p>

                <a href="{{ route('home') }}#catalogo" class="ui-btn-success mx-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    Ver catálogo
                </a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <div class="ui-glass p-6">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-zinc-800 dark:text-zinc-100">Calidad y confianza</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Productos seleccionados y disponibles, para que compres tranquilo.</p>
                </div>

                <div class="ui-glass p-6">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white shadow-lg shadow-fuchsia-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-zinc-800 dark:text-zinc-100">Atención personalizada</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Te asesoramos y resolvemos tus dudas antes y después de tu compra.</p>
                </div>

                <div class="ui-glass p-6">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-zinc-800 dark:text-zinc-100">Confirmás por WhatsApp</h2>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Tu pedido llega listo para confirmar al instante con nuestro equipo.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts::tienda>