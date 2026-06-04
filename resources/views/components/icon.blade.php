@props(['name', 'size' => '1.25rem'])

<iconify-icon icon="{{ $name }}" width="{{ $size }}" height="{{ $size }}" aria-hidden="true"
    {{ $attributes->merge(['class' => 'inline-block shrink-0 align-middle']) }}></iconify-icon>
