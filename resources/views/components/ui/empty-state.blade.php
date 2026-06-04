@props([
    'icon' => 'solar:inbox-line-duotone',
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-3xl border border-dashed border-ink-200 bg-ink-50 p-8 text-center']) }}>
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-brand-500 shadow-sm">
        <x-icon :name="$icon" size="1.6rem" />
    </div>
    <h3 class="mt-4 text-sm font-bold text-ink-900">{{ $title }}</h3>
    @if ($description)
        <p class="mt-2 text-sm leading-6 text-ink-500">{{ $description }}</p>
    @endif
</div>
