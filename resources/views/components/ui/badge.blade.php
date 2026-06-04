@props([
    'variant' => 'neutral',
])

@php
    $variants = [
        'neutral' => 'bg-ink-100 text-ink-600',
        'primary' => 'bg-brand-50 text-brand-700',
        'success' => 'bg-health-50 text-health-600',
        'warning' => 'bg-alert-50 text-alert-600',
        'danger' => 'bg-danger-50 text-danger-600',
    ];
@endphp

<span
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold ' . $variants[$variant]]) }}>
    {{ $slot }}
</span>
