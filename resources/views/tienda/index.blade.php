<x-layouts::tienda :title="__('Inicio')">
    @php($destacado = $productosDestacados->first())

    <section class="border-b border-border">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24">
            <div class="animate-fade-in-up">
                <p class="ui-eyebrow">Tienda oficial</p>

                <h1 class="mt-5 text-4xl font-extrabold tracking-tight text-text-primary sm:text-5xl lg:text-6xl">
                    Juguetes y moda
                    <span class="block text-accent">con estilo</span>
                </h1>

                <p class="mt-5 max-w-xl text-lg leading-relaxed text-text-secondary">
                    Explora nuestro catálogo, elige tus productos y completa tu pedido en minutos.
                    Calidad y atención personalizada en cada compra.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
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

                <div class="mt-10 grid grid-cols-3 gap-4 border-t border-border pt-6">
                    <div>
                        <p class="text-2xl font-extrabold text-text-primary">{{ $productosDestacados->count() }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-text-tertiary">Productos</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-text-primary">{{ $categoriasDestacadas->count() }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-text-tertiary">Categorías</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-text-primary">100%</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-text-tertiary">Atención</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="rounded-xl bg-navy p-6 sm:p-8">
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Selección de la semana</p>
                        <span class="h-px flex-1 bg-white/10"></span>
                    </div>

                    @if ($destacado)
                        <a href="{{ route('tienda.producto', $destacado->id) }}" wire:navigate class="group mt-6 block overflow-hidden rounded-xl bg-white">
                            <div class="aspect-[4/3] overflow-hidden bg-surface-muted">
                                @if ($destacado->imagen)
                                    <img src="{{ asset('storage/'.$destacado->imagen) }}" alt="{{ $destacado->nombre }}" class="size-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex size-full items-center justify-center text-text-tertiary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 8.25h.008v.008H18V8.25zm3 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-end justify-between gap-4 p-5">
                                <div>
                                    @if ($destacado->categorias->isNotEmpty())
                                        <p class="text-xs font-bold uppercase tracking-wide text-accent">{{ $destacado->categorias->first()->nombre }}</p>
                                    @endif
                                    <p class="mt-1 font-semibold text-navy">{{ $destacado->nombre }}</p>
                                </div>
                                <p class="whitespace-nowrap text-lg font-extrabold tabular-nums text-navy">${{ number_format($destacado->precio, 2) }}</p>
                            </div>
                        </a>
                    @else
                        <div class="mt-6 flex aspect-[4/3] flex-col items-center justify-center rounded-xl border border-white/10 bg-white/5 px-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-12 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                            </svg>
                            <p class="mt-3 font-semibold text-white">Catálogo en preparación</p>
                            <p class="mt-1 text-sm text-slate-400">Muy pronto encontrarás aquí nuestros productos destacados.</p>
                        </div>
                    @endif

                    <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-5">
                        <p class="text-sm text-slate-300">Compra segura y atención personalizada.</p>
                        <a href="{{ route('tienda.catalogo') }}" wire:navigate class="text-sm font-semibold text-accent transition-colors hover:text-white">Ver todo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-border bg-surface-muted">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 py-8 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
            <div class="flex items-start gap-3">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-navy text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                    </svg>
                </span>
                <div>
                    <p class="font-semibold text-text-primary">Productos seleccionados</p>
                    <p class="mt-1 text-sm text-text-secondary">Catálogo curado con disponibilidad en tiempo real.</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-navy text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </span>
                <div>
                    <p class="font-semibold text-text-primary">Compra segura</p>
                    <p class="mt-1 text-sm text-text-secondary">Tus datos y tu pedido respaldados en cada paso.</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-accent text-navy">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </span>
                <div>
                    <p class="font-semibold text-text-primary">Atención personalizada</p>
                    <p class="mt-1 text-sm text-text-secondary">Te acompañamos antes, durante y después de tu compra.</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-navy text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                </span>
                <div>
                    <p class="font-semibold text-text-primary">Entrega coordinada</p>
                    <p class="mt-1 text-sm text-text-secondary">Enviamos y coordinamos la entrega de tu pedido.</p>
                </div>
            </div>
        </div>
    </section>

    @if ($categoriasDestacadas->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="ui-eyebrow">Explora</p>
                    <h2 class="mt-2 text-2xl font-bold text-text-primary sm:text-3xl">Categorías destacadas</h2>
                </div>
                <a href="{{ route('tienda.catalogo') }}" wire:navigate class="inline-flex items-center gap-1 text-sm font-semibold text-accent transition-colors hover:text-accent-strong">
                    Ver catálogo completo
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                @foreach ($categoriasDestacadas as $categoria)
                    <a
                        href="{{ route('tienda.catalogo', ['categoria' => $categoria->id]) }}"
                        class="ui-card ui-card-hover group flex flex-col items-center gap-2 p-5 text-center"
                    >
                        <span class="flex size-12 items-center justify-center rounded-lg bg-navy text-white transition-colors group-hover:bg-accent group-hover:text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                        </span>
                        <span class="text-sm font-semibold text-text-primary transition-colors group-hover:text-accent">{{ $categoria->nombre }}</span>
                        <span class="text-xs text-text-tertiary">{{ $categoria->cantidad_productos }} {{ $categoria->cantidad_productos === 1 ? 'producto' : 'productos' }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @if ($productosDestacados->isNotEmpty())
        <section class="border-y border-border bg-surface-muted">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-16">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="ui-eyebrow">Novedades</p>
                        <h2 class="mt-2 text-2xl font-bold text-text-primary sm:text-3xl">Productos destacados</h2>
                    </div>
                    <a href="{{ route('tienda.catalogo') }}" wire:navigate class="inline-flex items-center gap-1 text-sm font-semibold text-accent transition-colors hover:text-accent-strong">
                        Ver todo el catálogo
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($productosDestacados as $producto)
                        <a
                            href="{{ route('tienda.producto', $producto->id) }}"
                            class="ui-card ui-card-hover group relative flex flex-col overflow-hidden"
                        >
                            <div class="relative aspect-square overflow-hidden bg-surface-muted">
                                @if ($producto->imagen)
                                    <img src="{{ asset('storage/'.$producto->imagen) }}" alt="{{ $producto->nombre }}" class="size-full object-cover transition-transform duration-300 ease-out group-hover:scale-105">
                                @else
                                    <div class="flex size-full items-center justify-center text-text-tertiary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 8.25h.008v.008H18V8.25zm3 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @endif

                                @if ($producto->created_at >= now()->subDays(7))
                                    <span class="ui-badge-new absolute left-3 top-3 z-10">Nuevo</span>
                                @endif

                                @if ($producto->stock <= 0)
                                    <span class="absolute right-3 top-3 rounded-md bg-navy px-2.5 py-1 text-xs font-semibold text-white">Agotado</span>
                                @endif
                            </div>

                            <div class="flex flex-1 flex-col p-4">
                                @if ($producto->categorias->isNotEmpty())
                                    <span class="text-xs font-bold uppercase tracking-wider text-accent">{{ $producto->categorias->first()->nombre }}</span>
                                @endif

                                <p class="mt-1 line-clamp-2 font-semibold text-text-primary transition-colors group-hover:text-accent">
                                    {{ $producto->nombre }}
                                </p>

                                <div class="mt-4 flex items-center justify-between border-t border-border pt-3">
                                    <span class="text-lg font-extrabold tabular-nums text-text-primary">${{ number_format($producto->precio, 2) }}</span>
                                    <span class="text-xs font-semibold text-text-tertiary transition-colors group-hover:text-accent">Ver detalle</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-navy">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 px-4 py-12 sm:flex-row sm:items-center sm:px-6 lg:px-8">
            <div>
                <h2 class="text-2xl font-bold text-white">Encuentra tu próximo favorito</h2>
                <p class="mt-2 text-sm text-slate-300">Explora el catálogo completo y arma tu pedido en minutos.</p>
            </div>
            <a href="{{ route('tienda.catalogo') }}" wire:navigate class="ui-btn-cta shrink-0 justify-center">
                Ir al catálogo
            </a>
        </div>
    </section>
</x-layouts::tienda>
