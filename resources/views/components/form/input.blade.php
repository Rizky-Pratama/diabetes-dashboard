@props([
    'label',
    'name',
    'type' => 'text',
    'placeholder' => null,
    'model' => null,
    'required' => false,
    'helper' => null,
])

<div>
    <label for="{{ $name }}" class="mb-2 block text-sm font-semibold text-ink-700">
        {{ $label }}
        @if ($required)
            <span class="text-danger-500">*</span>
        @endif
    </label>

    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}"
        @if ($model) wire:model.live="{{ $model }}" @endif @required($required)
        {{ $attributes->merge([
            'class' =>
                'w-full rounded-2xl border border-ink-200 bg-white px-4 py-3 text-sm text-ink-900 outline-none transition placeholder:text-ink-400 focus:border-brand-400 focus:ring-4 focus:ring-brand-100 disabled:cursor-not-allowed disabled:bg-ink-100 disabled:text-ink-500',
        ]) }}>

    @if ($helper)
        <p class="mt-2 text-xs leading-5 text-ink-500">{{ $helper }}</p>
    @endif

    @error($model ?? $name)
        <p class="mt-2 text-xs font-medium text-danger-600">{{ $message }}</p>
    @enderror
</div>
