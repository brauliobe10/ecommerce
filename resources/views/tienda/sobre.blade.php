<x-layouts::tienda :title="__('Sobre nosotros')">
    <section class="border-b border-border">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="mx-auto max-w-3xl text-center">
                <p class="ui-eyebrow justify-center">Sobre nosotros</p>

                <h1 class="mt-5 text-4xl font-extrabold tracking-tight text-text-primary sm:text-5xl">
                    Conoce
                    <span class="text-accent">{{ config('app.name', 'KodeTech') }}</span>
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-lg leading-relaxed text-text-secondary">
                    Somos tu tienda de confianza. Elige de nuestro catálogo, arma tu pedido y completa tu compra
                    de forma simple, rápida y segura.
                </p>

                <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    <a href="{{ route('tienda.catalogo') }}" wire:navigate class="ui-btn-cta justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        Ver catálogo
                    </a>

                    <a href="{{ route('tienda.contacto') }}" wire:navigate class="ui-btn-secondary justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        Contáctanos
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-border bg-surface-muted">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
            <div class="mx-auto max-w-2xl text-center">
                <p class="ui-eyebrow justify-center">Lo que nos mueve</p>
                <h2 class="mt-3 text-2xl font-bold text-text-primary sm:text-3xl">Más que una tienda, un aliado para elegir</h2>
                <p class="mt-3 text-text-secondary">Trabajamos para que cada compra sea simple, segura y a tu ritmo.</p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-lg bg-navy text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-text-primary">Calidad y confianza</h3>
                    <p class="mt-2 text-sm text-text-secondary">Productos seleccionados y disponibles, para que compres tranquilo.</p>
                </div>

                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-lg bg-accent text-navy">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-text-primary">Atención personalizada</h3>
                    <p class="mt-2 text-sm text-text-secondary">Te asesoramos y resolvemos tus dudas antes y después de tu compra.</p>
                </div>

                <div class="ui-card ui-card-hover p-6">
                    <div class="flex size-12 items-center justify-center rounded-lg bg-navy text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-text-primary">Entrega coordinada</h3>
                    <p class="mt-2 text-sm text-text-secondary">Coordinamos el envío y la entrega de tu pedido de forma ágil.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-border">
        <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-16">
            <div>
                <p class="ui-eyebrow">Nuestra historia</p>
                <h2 class="mt-3 text-2xl font-bold text-text-primary sm:text-3xl">Una tienda pensada para acompañarte</h2>

                <p class="mt-4 leading-relaxed text-text-secondary">
                    En {{ config('app.name', 'KodeTech') }} reunimos juguetes y artículos de moda seleccionados
                    para que encuentres lo que buscas sin complicaciones. Creemos que comprar en línea debe ser
                    tan sencillo como elegir, escribir y recibir.
                </p>

                <p class="mt-4 leading-relaxed text-text-secondary">
                    Por eso cuidamos cada detalle: un catálogo claro, precios visibles y un canal directo para
                    resolver tus dudas. Así puedes dedicar tu tiempo a elegir, no a adivinar.
                </p>

                <ul class="mt-6 space-y-3">
                    @foreach (['Catálogo actualizado con disponibilidad real', 'Atención directa por WhatsApp', 'Envíos y entregas coordinadas contigo'] as $compromiso)
                        <li class="flex items-start gap-3">
                            <span class="flex size-6 shrink-0 items-center justify-center rounded-full bg-accent/10 text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium text-text-primary">{{ $compromiso }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-xl bg-navy p-6 sm:p-8">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Nuestro compromiso</p>

                <div class="mt-6 space-y-5">
                    <div class="border-b border-white/10 pb-5">
                        <p class="text-2xl font-extrabold text-accent">01</p>
                        <p class="mt-1 font-semibold text-white">Selección cuidada</p>
                        <p class="mt-1 text-sm text-slate-400">Elegimos productos que sumen a tu día a día.</p>
                    </div>

                    <div class="border-b border-white/10 pb-5">
                        <p class="text-2xl font-extrabold text-accent">02</p>
                        <p class="mt-1 font-semibold text-white">Trato cercano</p>
                        <p class="mt-1 text-sm text-slate-400">Una persona real te responde y te asesora.</p>
                    </div>

                    <div>
                        <p class="text-2xl font-extrabold text-accent">03</p>
                        <p class="mt-1 font-semibold text-white">Entrega coordinada</p>
                        <p class="mt-1 text-sm text-slate-400">Acordamos contigo la mejor forma de recibir tu pedido.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-border bg-surface-muted">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
            <div class="mx-auto max-w-2xl text-center">
                <p class="ui-eyebrow justify-center">Cómo comprar</p>
                <h2 class="mt-3 text-2xl font-bold text-text-primary sm:text-3xl">Tu pedido en cuatro pasos</h2>
                <p class="mt-3 text-text-secondary">Sin registros complicados ni procesos largos. Así de fácil.</p>
            </div>

            @php
                $pasos = [
                    ['titulo' => 'Explora el catálogo', 'descripcion' => 'Encuentra tus productos favoritos por categoría o búscalos directamente.'],
                    ['titulo' => 'Arma tu pedido', 'descripcion' => 'Agrega productos al carrito y ajusta las cantidades que necesites.'],
                    ['titulo' => 'Confirma por WhatsApp', 'descripcion' => 'Completa tus datos y envía el pedido; te respondemos para coordinar.'],
                    ['titulo' => 'Recibe tu compra', 'descripcion' => 'Acordamos contigo la entrega o el envío de tu pedido.'],
                ];
            @endphp

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($pasos as $index => $paso)
                    <div class="ui-card ui-card-hover p-6">
                        <span class="flex size-10 items-center justify-center rounded-full bg-accent font-extrabold text-navy">{{ $index + 1 }}</span>
                        <h3 class="mt-4 font-semibold text-text-primary">{{ $paso['titulo'] }}</h3>
                        <p class="mt-2 text-sm text-text-secondary">{{ $paso['descripcion'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-navy">
        <div class="pointer-events-none absolute -right-24 -top-24 size-72 rounded-full bg-accent/10 blur-3xl"></div>

        <div class="relative mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 px-4 py-12 sm:px-6 lg:flex-row lg:items-center lg:px-8">
            <div class="max-w-xl">
                <p class="ui-eyebrow">Empieza hoy</p>
                <h2 class="mt-3 text-2xl font-bold text-white sm:text-3xl">Tu próxima compra empieza aquí</h2>
                <p class="mt-2 text-pretty text-sm leading-relaxed text-slate-300">Explora el catálogo o escríbenos si necesitas ayuda para elegir. Te acompañamos en cada paso.</p>
            </div>

            <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                <a href="{{ route('tienda.catalogo') }}" wire:navigate class="ui-btn-cta shrink-0 justify-center">
                    Ver catálogo
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
                <a href="{{ route('tienda.contacto') }}" wire:navigate class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-white/25 bg-white/5 px-5 py-3 font-semibold text-white transition-colors duration-200 hover:border-accent hover:bg-white/10 hover:text-accent focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent/50 focus-visible:ring-offset-2 focus-visible:ring-offset-navy">
                    Contáctanos
                </a>
            </div>
        </div>
    </section>
</x-layouts::tienda>
