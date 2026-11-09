@props([
    'direccion' => 'flat',
    'porcentaje' => null,
])

@php
    $porcentaje = $porcentaje !== null ? abs((float) $porcentaje) : null;
@endphp

@if ($direccion === 'nuevo')
    <span {{ $attributes->merge(['class' => 'ui-badge-success whitespace-nowrap']) }}>Nuevo</span>
@elseif ($direccion === 'up')
    <span {{ $attributes->merge(['class' => 'ui-badge-success whitespace-nowrap']) }}>
        <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
        {{ number_format($porcentaje ?? 0, 1) }}%
    </span>
@elseif ($direccion === 'down')
    <span {{ $attributes->merge(['class' => 'ui-badge-danger whitespace-nowrap']) }}>
        <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
        {{ number_format($porcentaje ?? 0, 1) }}%
    </span>
@else
    <span {{ $attributes->merge(['class' => 'ui-badge-info whitespace-nowrap']) }}>
        {{ $porcentaje === null ? '—' : number_format($porcentaje, 1).'%' }}
    </span>
@endif
