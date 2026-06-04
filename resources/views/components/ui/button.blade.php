@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $base =
        'inline-flex items-center justify-center gap-2 rounded-full font-semibold transition focus:outline-none focus:ring-4 disabled:pointer-events-none disabled:opacity-60';

    $variants = [
        'primary' => 'bg-brand-500 text-white shadow-sm shadow-brand-500/20 hover:bg-brand-600 focus:ring-brand-100',
        'secondary' => 'bg-ink-900 text-white shadow-sm hover:bg-ink-800 focus:ring-ink-200',
        'soft' => 'bg-brand-50 text-brand-700 hover:bg-brand-100 focus:ring-brand-100',
        'light' => 'bg-white text-ink-700 ring-1 ring-ink-200 hover:bg-ink-50 focus:ring-ink-100',
        'danger' => 'bg-danger-50 text-danger-600 hover:bg-danger-100 focus:ring-danger-100',
        'ghost' => 'text-ink-600 hover:bg-ink-100 hover:text-ink-900 focus:ring-ink-100',
    ];

    $sizes = [
        'sm' => 'px-3 py-2 text-xs',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
@endphp

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => $base . ' ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
    {{ $slot }}
</button>
