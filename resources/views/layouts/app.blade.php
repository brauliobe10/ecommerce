@auth
    @if (auth()->user()->isCliente())
        <x-layouts::tienda :title="$title ?? null">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                @include('partials.account-nav')

                {{ $slot }}
            </div>
        </x-layouts::tienda>
    @else
        <x-layouts::app.sidebar :title="$title ?? null">
            <flux:main>
                {{ $slot }}
            </flux:main>
        </x-layouts::app.sidebar>
    @endif
@else
    <x-layouts::app.sidebar :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts::app.sidebar>
@endauth
