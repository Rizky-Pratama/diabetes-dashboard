@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
            <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Edukasi Hasil Prediksi</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-900">Kelola edukasi otomatis</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">Konten edukasi akan ditampilkan berdasarkan nilai
                hasil prediksi: normal, prediabetes, atau diabetes.</p>
        </section>

        @livewire(\App\Livewire\EducationContentManager::class)
    </div>
@endsection
