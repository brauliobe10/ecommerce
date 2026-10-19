<x-layouts::tienda :title="__('Sobre nosotros')">
    <section class="relative overflow-hidden border-b border-border dark:border-zinc-800">
        <div class="ui-gradient-soft absolute inset-0" aria-hidden="true"></div>
        <div class="ui-orb -left-20 top-0 size-64 bg-arena/70 dark:bg-arena/20"></div>
        <div class="ui-orb -right-16 bottom-0 size-56 bg-accent/15 dark:bg-accent/10"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="mx-auto max-w-3xl text-center">
                <span class="ui-section-eyebrow">
                    Sobre nosotros
                </span>

                <h1 class="mt-5 text-4xl font-extrabold tracking-tight sm:text-5xl">
                    Conocé
                    <span class="ui-text-gradient">{{ config('app.name', 'KodeTech') }}</span>
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-lg leading-relaxed text-text-secondary">
                    Somos tu tienda de confianza. Elegí de nuestro catálogo, armá tu pedido y completá tu compra
                    de forma simple, rápida y segura.
                </p>

                <a href="{{ route('tienda.catalogo') }}" wire:navigate class="ui-btn-primary mx-auto mt-8 justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    Ver catálogo
                </a>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-navy text-white shadow-[0_8px_18px_-8px_rgba(41,41,41,0.5)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-text-primary">Calidad y confianza</h2>
                    <p class="mt-2 text-sm text-text-secondary">Productos seleccionados y disponibles, para que compres tranquilo.</p>
                </div>

                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-accent text-navy shadow-[0_8px_18px_-8px_rgba(199,167,108,0.6)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-text-primary">Atención personalizada</h2>
                    <p class="mt-2 text-sm text-text-secondary">Te asesoramos y resolvemos tus dudas antes y después de tu compra.</p>
                </div>

                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-[#5F7050] text-white shadow-[0_8px_18px_-8px_rgba(41,41,41,0.45)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-text-primary">Entrega coordinada</h2>
                    <p class="mt-2 text-sm text-text-secondary">Coordinamos el envío y la entrega de tu pedido de forma ágil.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts::tienda>
