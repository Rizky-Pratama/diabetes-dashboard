@extends('layouts.app')

@section('content')
    <article class="mx-auto max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('articles.index') }}" wire:navigate
                class="inline-flex items-center gap-2 text-sm font-bold text-ink-500 transition hover:text-brand-700">
                <x-icon name="solar:arrow-left-line-duotone" size="1rem" />
                Kembali ke daftar artikel
            </a>
        </div>

        <header class="space-y-5">
            <div class="flex flex-wrap items-center gap-2">
                <x-ui.badge :variant="$article->status === 'published' ? 'success' : 'neutral'">
                    {{ ucfirst($article->status) }}
                </x-ui.badge>
                <span class="text-sm font-semibold text-ink-400">{{ $article->created_at->format('d M Y') }}</span>
            </div>

            <h1 class="text-3xl font-bold leading-tight text-ink-900 sm:text-4xl">
                {{ $article->title }}
            </h1>

            <p class="max-w-3xl text-base leading-7 text-ink-500">
                Artikel edukasi DiaPredict untuk membantu kamu memahami informasi kesehatan dengan bahasa
                yang lebih mudah diikuti.
            </p>
        </header>

        <div class="mt-8 overflow-hidden rounded-[2rem] border border-ink-100 bg-brand-50">
            @if ($article->thumbnail)
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->thumbnail) }}"
                    alt="{{ $article->title }}" class="h-full max-h-[30rem] w-full object-cover" />
            @else
                <div class="flex aspect-video w-full items-center justify-center text-brand-500">
                    <x-icon name="solar:document-text-line-duotone" size="4rem" />
                </div>
            @endif
        </div>

        <x-ui.card class="mt-8">
            <x-content.quill-viewer :content="$article->content" :framed="false"
                class="[&_.ql-editor]:text-base [&_.ql-editor]:leading-8 [&_.ql-editor_h1]:text-3xl [&_.ql-editor_h2]:text-2xl [&_.ql-editor_a]:font-bold [&_.ql-editor_a]:text-brand-700"
                min-height="min-h-0" />
        </x-ui.card>
    </article>

    @if ($relatedArticles->isNotEmpty())
        <section class="mx-auto mt-10 max-w-4xl">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h2 class="text-lg font-bold text-ink-900">Artikel lainnya</h2>
                <x-ui.badge variant="primary">{{ $relatedArticles->count() }} rekomendasi</x-ui.badge>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                @foreach ($relatedArticles as $relatedArticle)
                    <a href="{{ route('articles.show', $relatedArticle) }}" wire:navigate
                        class="rounded-2xl border border-ink-100 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        <div class="text-sm font-bold leading-snug text-ink-900">{{ $relatedArticle->title }}</div>
                        <p class="mt-2 line-clamp-3 text-sm leading-6 text-ink-500">
                            {{ \Illuminate\Support\Str::limit(strip_tags($relatedArticle->content), 100) }}
                        </p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection
