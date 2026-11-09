@props([
    'title',
    'subtitle' => null,
])

<section {{ $attributes->merge(['class' => 'ui-card min-w-0 p-5 sm:p-6']) }}>
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <h2 class="text-sm font-semibold text-text-primary">{{ $title }}</h2>
            @if ($subtitle)
                <p class="mt-1 text-xs text-text-tertiary">{{ $subtitle }}</p>
            @endif
        </div>

        @isset($actions)
            <div class="flex items-center gap-2">{{ $actions }}</div>
        @endisset
    </div>

    <div class="mt-5">{{ $slot }}</div>
</section>
