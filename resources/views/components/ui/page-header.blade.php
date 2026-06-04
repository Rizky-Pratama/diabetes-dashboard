@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'logo' => null,
])

<div
    {{ $attributes->merge(['class' => 'flex items-center gap-6 mb-8 rounded-3xl border border-ink-100 bg-white p-6 shadow-sm sm:p-8']) }}>
    @if ($logo)
        <div class="h-18 w-18 shrink-0 overflow-hidden rounded-2xl sm:block">
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($logo) }}" alt="Logo"
                class="h-full w-full object-cover" />
        </div>
    @endif
    <div class="flex-1">
        @if ($eyebrow)
            <p class="mb-2 text-xs font-bold uppercase tracking-[0.32em] text-brand-600">
                {{ $eyebrow }}
            </p>
        @endif
        <div class="flex flex-col justify-between gap-4 lg:flex-row lg:items-end">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-ink-900 sm:text-3xl">
                    {{ $title }}
                </h1>
                @if ($description)
                    <p class="mt-2 max-w-3xl text-sm leading-6 text-ink-500 sm:text-base">
                        {{ $description }}
                    </p>
                @endif
            </div>
            @isset($action)
                <div class="shrink-0">
                    {{ $action }}
                </div>
            @endisset
        </div>
    </div>
</div>
