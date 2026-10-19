<x-layouts::tienda :title="__('Catálogo')">
    <section class="relative overflow-hidden border-b border-border dark:border-zinc-800">
        <div class="ui-gradient-soft absolute inset-0" aria-hidden="true"></div>
        <div class="ui-orb -right-16 -top-10 size-56 bg-accent/20 dark:bg-accent/15"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-14">
            <span class="ui-section-eyebrow">
                Tienda
            </span>

            <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">
                <span class="ui-text-gradient">Catálogo de productos</span>
            </h1>

            <p class="mt-3 max-w-2xl text-base leading-relaxed text-text-secondary">
                Explorá todos nuestros productos disponibles, filtrá por categoría y agregá lo que necesites al carrito.
            </p>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-12">
        <livewire:tienda.catalogo />
    </div>
</x-layouts::tienda>
