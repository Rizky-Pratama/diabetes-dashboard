@props(['content' => '', 'minHeight' => 'min-h-24', 'framed' => true])

@pushOnce('scripts', 'quill-assets')
    @vite('resources/js/pages/article.js')
@endPushOnce

@php
    $classes = $framed ? 'rounded-2xl border border-ink-100 bg-white p-4' : '';
@endphp

<div x-data="quillViewer(@js($content))"
    {{ $attributes->merge(['class' => $classes . ' [&_.ql-container]:border-0 [&_.ql-editor]:p-0 [&_.ql-editor]:text-sm [&_.ql-editor]:leading-6 [&_.ql-editor]:text-ink-600']) }}>
    <div wire:ignore>
        <div x-ref="viewer" class="{{ $minHeight }}"></div>
    </div>
</div>
