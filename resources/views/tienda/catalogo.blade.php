<x-layouts::tienda :title="__('Catálogo')">
    <section class="border-b border-border">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-14">
            <p class="ui-eyebrow">Tienda</p>

            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-text-primary sm:text-4xl">
                Catálogo de productos
            </h1>

            <p class="mt-3 max-w-2xl text-base leading-relaxed text-text-secondary">
                Explora todos nuestros productos disponibles, filtra por categoría y agrega lo que necesites al carrito.
            </p>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-12">
        <livewire:tienda.catalogo />
    </div>
</x-layouts::tienda>
