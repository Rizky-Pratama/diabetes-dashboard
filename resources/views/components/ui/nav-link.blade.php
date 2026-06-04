@props(['href', 'active' => false, 'icon' => null])

<a href="{{ $href }}" wire:navigate
    {{ $attributes->merge([
        'class' =>
            'inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition ' .
            ($active ? 'bg-brand-50 text-brand-700' : 'text-ink-600 hover:bg-ink-100 hover:text-ink-900'),
    ]) }}>
    @if ($icon)
        <x-icon :name="$icon" size="1.05rem" />
    @endif
    {{ $slot }}
</a>
