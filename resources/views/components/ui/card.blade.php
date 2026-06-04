@props([
    'padding' => 'p-6',
    'hover' => false,
])

@php
    $classes = 'rounded-3xl border border-ink-100 bg-white shadow-sm';
    $classes .= $hover ? ' transition hover:-translate-y-0.5 hover:shadow-md' : '';
@endphp

<section {{ $attributes->merge(['class' => $classes . ' ' . $padding]) }}>
    {{ $slot }}
</section>
