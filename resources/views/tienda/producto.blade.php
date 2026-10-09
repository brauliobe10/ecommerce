<x-layouts::tienda :title="$producto->nombre">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <livewire:tienda.producto :producto="$producto->id" />
    </div>
</x-layouts::tienda>
