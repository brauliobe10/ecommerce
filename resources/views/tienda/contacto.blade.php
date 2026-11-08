<x-layouts::tienda :title="__('Contacto')">
    <section class="border-b border-border">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="mx-auto max-w-3xl text-center">
                <p class="ui-eyebrow justify-center">¿Hablamos?</p>

                <h1 class="mt-5 text-4xl font-extrabold tracking-tight text-text-primary sm:text-5xl">
                    Contáctanos en
                    <span class="text-accent">{{ config('app.name', 'KodeTech') }}</span>
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
                    <div class="flex size-12 items-center justify-center rounded-lg bg-navy text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0021 18V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v12a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-text-primary">WhatsApp</h2>
                    <p class="mt-2 text-sm text-text-secondary">Respuesta rápida para pedidos, encargos y consultas.</p>
                </div>

                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-lg bg-accent text-navy">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-text-primary">Ubicación</h2>
                    <p class="mt-2 text-sm text-text-secondary">San Luis 246, Chiclayo 14001. Envíos y entregas coordinadas.</p>
                </div>

                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-lg bg-navy text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="mt-4 text-lg font-semibold text-text-primary">Horario</h2>
                    <p class="mt-2 text-sm text-text-secondary">Recibimos consultas todos los días y respondemos a la brevedad.</p>
                </div>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-5">
                <div class="ui-card flex flex-col p-6 sm:p-8 lg:col-span-2">
                    <p class="ui-eyebrow">Visítanos</p>
                    <h2 class="mt-3 text-2xl font-bold text-text-primary">Estamos en Chiclayo</h2>
                    <p class="mt-3 text-sm leading-relaxed text-text-secondary">
                        Puedes ubicarnos en San Luis 246, Chiclayo 14001. Coordinamos pedidos, envíos y entregas por WhatsApp.
                    </p>

                    <dl class="mt-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-navy text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                            </span>
                            <div>
                                <dt class="text-sm font-semibold text-text-primary">Dirección</dt>
                                <dd class="mt-1 text-sm text-text-secondary">San Luis 246, Chiclayo 14001 – Perú</dd>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-accent text-navy">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div>
                                <dt class="text-sm font-semibold text-text-primary">Horario</dt>
                                <dd class="mt-1 text-sm text-text-secondary">Consultas todos los días, respuesta a la brevedad.</dd>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-navy text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                                </svg>
                            </span>
                            <div>
                                <dt class="text-sm font-semibold text-text-primary">WhatsApp</dt>
                                <dd class="mt-1 text-sm text-text-secondary">Atención directa para pedidos y encargos.</dd>
                            </div>
                        </div>
                    </dl>

                    <div class="mt-auto flex flex-col gap-3 pt-6 sm:flex-row">
                        <a href="https://www.google.com/maps/search/?api=1&query=San+Luis+246,+Chiclayo+14001,+Peru" target="_blank" rel="noopener" class="ui-btn-primary justify-center">
                            Cómo llegar
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        @if (filled($whatsapp))
                            <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" class="ui-btn-secondary justify-center">
                                Escríbenos
                            </a>
                        @endif
                    </div>
                </div>

                <div class="ui-card overflow-hidden lg:col-span-3">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3962.007415736216!2d-79.83081472491143!3d-6.768948666193601!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x904ce92ae8050331%3A0x349eb1c1660d2fd5!2sSan%20Luis%20246%2C%20Chiclayo%2014001!5e0!3m2!1ses!2spe!4v1794112787121!5m2!1ses!2spe"
                        class="block h-full min-h-[360px] w-full lg:min-h-[440px]"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                        title="Ubicación de {{ config('app.name', 'KodeTech') }} en San Luis 246, Chiclayo"
                    ></iframe>
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
