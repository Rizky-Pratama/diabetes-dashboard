@extends('layouts.app')

@section('content')
    <x-ui.page-header eyebrow="Artikel Edukasi" title="Bacaan kesehatan untuk mendampingi prediksi"
        description="Pilih artikel yang ingin dibaca. Semua konten di halaman ini sudah dipublikasikan oleh admin.">
        <x-slot:action>
            <x-ui.badge variant="success">
                <x-icon name="solar:document-text-line-duotone" size="1rem" />
                {{ $articles->total() }} Artikel
            </x-ui.badge>
        </x-slot:action>
    </x-ui.page-header>

    <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($articles as $article)
            <article class="overflow-hidden rounded-3xl border border-ink-100 bg-white shadow-sm">
                <a href="{{ route('articles.show', $article) }}" wire:navigate class="block">
                    <div class="aspect-video bg-brand-50">
                        @if ($article->thumbnail)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->thumbnail) }}"
                                alt="{{ $article->title }}" class="h-full w-full object-cover" />
                        @else
                            <div class="flex h-full w-full items-center justify-center text-brand-500">
                                <x-icon name="solar:document-text-line-duotone" size="3rem" />
                            </div>
                        @endif
                    </div>
                </a>

                <div class="p-6">
                    <div class="flex items-center gap-2">
                        <x-ui.badge variant="primary">DiaPredict</x-ui.badge>
                        <span class="text-xs font-semibold text-ink-400">{{ $article->created_at->format('d M Y') }}</span>
                    </div>

                    <h2 class="mt-4 text-xl font-bold leading-snug text-ink-900">
                        <a href="{{ route('articles.show', $article) }}" wire:navigate
                            class="transition hover:text-brand-700">
                            {{ $article->title }}
                        </a>
                    </h2>

                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-ink-500">
                        {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 150) }}
                    </p>

                    <a href="{{ route('articles.show', $article) }}" wire:navigate
                        class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-brand-700 hover:text-brand-800">
                        Baca detail
                        <x-icon name="solar:arrow-right-line-duotone" size="1rem" />
                    </a>
                </div>
            </article>
        @empty
            <div class="md:col-span-2 xl:col-span-3">
                <x-ui.empty-state icon="solar:document-text-line-duotone" title="Belum ada artikel published."
                    description="Artikel yang sudah dipublikasikan admin akan tampil di sini." />
            </div>
        @endforelse
    </section>

    <div class="mt-8">{{ $articles->links() }}</div>
@endsection
