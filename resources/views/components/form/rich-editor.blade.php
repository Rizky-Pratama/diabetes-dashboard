@props(['label', 'name', 'model', 'placeholder' => 'Tulis konten artikel...'])

@pushOnce('scripts', 'quill-assets')
    @vite('resources/js/pages/article.js')
@endPushOnce

<div x-data="quillEditor(@entangle($model).live)">
    <label for="{{ $name }}" class="mb-2 block text-sm font-semibold text-ink-700">
        {{ $label }}
    </label>

    <div wire:ignore
        class="rounded-2xl border border-ink-200 bg-white focus-within:border-brand-400 focus-within:ring-4 focus-within:ring-brand-100">
        <div x-ref="editor" class="min-h-56 text-sm"></div>
    </div>

    @error($model)
        <p class="mt-2 text-xs font-medium text-danger-600">{{ $message }}</p>
    @enderror
</div>
