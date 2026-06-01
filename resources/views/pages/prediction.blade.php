@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
            <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Prediksi Diabetes</p>
            <h1 class="mt-1 text-2xl font-semibold text-slate-900">Mulai prediksi dengan data yang sederhana</h1>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">Isi lima input kesehatan, kirim ke API Python, lalu
                simpan hasil prediksi ke riwayat secara otomatis.</p>
        </section>

        <div class="grid gap-6 xl:grid-cols-2">
            @livewire(\App\Http\Livewire\PredictionForm::class)
            @livewire(\App\Http\Livewire\PredictionHistoryList::class)
        </div>
    </div>
@endsection
