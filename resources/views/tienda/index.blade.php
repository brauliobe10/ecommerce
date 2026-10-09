<x-layouts::tienda :title="__('Inicio')">
    <section class="border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-2xl">
                <span class="ui-badge-info">Compra fácil y confirma por WhatsApp</span>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                    Encuentra lo que necesitas en <span class="text-indigo-600 dark:text-indigo-400">{{ config('app.name', 'KodeTech') }}</span>
                </h1>
                <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">
                    Explora nuestro catálogo, agrega tus productos al carrito y confirma tu pedido por WhatsApp en segundos.
                </p>
            </div>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <livewire:tienda.catalogo />
    </div>
</x-layouts::tienda>
