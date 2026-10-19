<x-layouts::tienda :title="__('Contacto')">
    <section class="relative overflow-hidden border-b border-border dark:border-zinc-800">
        <div class="ui-gradient-soft absolute inset-0" aria-hidden="true"></div>
        <div class="ui-orb -left-16 bottom-0 size-60 bg-accent/20 dark:bg-accent/15"></div>
        <div class="ui-orb -right-20 top-0 size-64 bg-accent/15 dark:bg-accent/10"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="mx-auto max-w-3xl text-center">
                <span class="ui-section-eyebrow">
                    ¿Hablamos?
                </span>

                <h1 class="mt-5 text-4xl font-extrabold tracking-tight sm:text-5xl">
                    Contáctanos en
                    <span class="ui-text-gradient">{{ config('app.name', 'KodeTech') }}</span>
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-lg leading-relaxed text-text-secondary">
                    Tienes dudas sobre un producto, tu pedido o quieres hacer un encargo. Estamos para ayudarte.
                </p>

                @php($whatsapp = preg_replace('/\D+/', '', (string) config('services.whatsapp.number')))
                @if (filled($whatsapp))
                    <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="ui-btn-success mx-auto mt-8 justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Escríbenos por WhatsApp
                    </a>
                @endif
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-[#5F7050] text-white shadow-[0_8px_18px_-8px_rgba(41,41,41,0.45)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-text-primary">WhatsApp</h2>
                    <p class="mt-2 text-sm text-text-secondary">Respuesta rápida para pedidos, encargos y consultas.</p>
                </div>

                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-navy text-white shadow-[0_8px_18px_-8px_rgba(41,41,41,0.5)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-text-primary">Ubicación</h2>
                    <p class="mt-2 text-sm text-text-secondary">Atendemos pedidos online con envíos y entrega coordinada.</p>
                </div>

                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-xl bg-accent text-navy shadow-[0_8px_18px_-8px_rgba(199,167,108,0.6)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-text-primary">Horario</h2>
                    <p class="mt-2 text-sm text-text-secondary">Recibimos consultas todos los días y respondemos a la brevedad.</p>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('home') }}" wire:navigate class="ui-btn-secondary mx-auto justify-center">
                    Volver al inicio
                </a>
            </div>
        </div>
    </section>
</x-layouts::tienda>
