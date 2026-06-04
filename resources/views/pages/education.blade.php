@extends('layouts.app')

@section('content')
    <x-ui.page-header eyebrow="Edukasi Hasil Prediksi" title="Kelola edukasi otomatis"
        description="Konten edukasi akan ditampilkan berdasarkan nilai hasil prediksi: normal, prediabetes, atau diabetes.">
        <x-slot:action>
            <x-ui.badge variant="warning">
                <x-icon name="solar:notebook-bookmark-line-duotone" size="1rem" />
                Dinamis
            </x-ui.badge>
        </x-slot:action>
    </x-ui.page-header>

    @livewire(\App\Livewire\EducationContentManager::class)
@endsection
