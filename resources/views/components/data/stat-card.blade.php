@props(['label', 'value', 'description' => null, 'variant' => 'primary', 'icon' => null])

@php
    $variants = [
        'primary' => 'bg-brand-50 text-brand-600',
        'success' => 'bg-health-50 text-health-600',
        'warning' => 'bg-alert-50 text-alert-600',
        'danger' => 'bg-danger-50 text-danger-600',
        'neutral' => 'bg-ink-100 text-ink-600',
    ];
@endphp

<x-ui.card hover>
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-ink-500">{{ $label }}</p>
            <p class="mt-3 text-3xl font-bold tracking-tight text-ink-900">{{ $value }}</p>
            @if ($description)
                <p class="mt-2 text-xs leading-5 text-ink-500">{{ $description }}</p>
            @endif
        </div>

        @if ($icon)
            <div class="rounded-2xl p-3 {{ $variants[$variant] }}">
                <x-icon :name="$icon" size="1.35rem" />
            </div>
        @endif
    </div>
</x-ui.card>
