@extends('layouts.app')

@section('content')
    <x-ui.page-header eyebrow="Manajemen Artikel" title="Kelola artikel edukasi"
        description="Halaman ini hanya untuk admin. Pengguna dan petugas membaca artikel melalui halaman daftar dan detail.">
        <x-slot:action>
            <x-ui.badge variant="primary">
                <x-icon name="solar:document-text-line-duotone" size="1rem" />
                Admin
            </x-ui.badge>
        </x-slot:action>
    </x-ui.page-header>

    @livewire(\App\Http\Livewire\ArticleManager::class)
@endsection
