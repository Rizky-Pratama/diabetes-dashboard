@extends('layouts.app')

@section('content')
    <x-ui.page-header eyebrow="Prediksi Diabetes" title="Mulai prediksi dengan data kesehatan"
        description="Isi parameter pemeriksaan, simpan audit trail prediksi, lalu tampilkan edukasi otomatis sesuai hasil.">
    </x-ui.page-header>

    @livewire(\App\Http\Livewire\PredictionManager::class)
@endsection
