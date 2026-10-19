@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand :name="config('app.name', 'Laravel')" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg bg-accent text-navy shadow-[0_6px_14px_-6px_rgba(199,167,108,0.7)]">
            <x-app-logo-icon class="size-5 fill-current text-navy" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="config('app.name', 'KodeTech')" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg bg-accent text-navy shadow-[0_6px_14px_-6px_rgba(199,167,108,0.7)]">
            <x-app-logo-icon class="size-5 fill-current text-navy" />
        </x-slot>
    </flux:brand>
@endif
