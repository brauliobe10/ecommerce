<x-layouts::tienda :title="__('Catálogo')">
    <section class="border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-14">
            <span class="ui-section-eyebrow">
                <span class="h-px w-6 bg-indigo-500"></span>
                Tienda
            </span>

            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-4xl">
                Catálogo de productos
            </h1>

            <p class="mt-3 max-w-2xl text-base leading-relaxed text-zinc-600 dark:text-zinc-300">
                Explorá todos nuestros productos disponibles, filtrá por categoría y agregá lo que necesites al carrito.
            </p>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-12">
        <livewire:tienda.catalogo />
    </div>
</x-layouts::tienda>
