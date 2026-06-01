@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
            <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Artikel Edukasi</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-900">Informasi kesehatan yang mudah dibaca</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">Artikel ditampilkan dalam card sederhana agar nyaman
                di desktop maupun mobile.</p>
        </section>

        @livewire(\App\Http\Livewire\ArticleManager::class)
    </div>
@endsection
