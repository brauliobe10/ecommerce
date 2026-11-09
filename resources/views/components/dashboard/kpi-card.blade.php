@props([
    'label',
    'value',
    'href',
    'iconBg' => 'bg-accent/10 text-accent-strong dark:bg-accent/15 dark:text-accent',
])

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'ui-card ui-card-hover group animate-fade-in-up min-w-0 p-5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent/50 focus-visible:ring-offset-2 focus-visible:ring-offset-bg']) }}
>
    <div class="flex items-start justify-between gap-3">
        <div class="flex min-w-0 items-center gap-2.5">
            <span class="flex size-9 shrink-0 items-center justify-center rounded-lg {{ $iconBg }}">
                {{ $icon }}
            </span>
            <span class="truncate text-sm font-semibold text-text-secondary">{{ $label }}</span>
        </div>

        {{ $trend }}
    </div>

    <p class="mt-4 text-2xl font-extrabold tracking-tight tabular-nums text-text-primary sm:text-3xl">{{ $value }}</p>
    <div class="mt-1 text-xs text-text-tertiary">{{ $subtext }}</div>
</a>
