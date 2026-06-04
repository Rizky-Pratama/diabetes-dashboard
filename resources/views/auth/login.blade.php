@extends('layouts.app')

@section('content')
    <div class="mx-auto grid min-h-[calc(100vh-10rem)] max-w-5xl items-center gap-8 lg:grid-cols-2">
        <section class="hidden lg:block">
            <x-ui.badge variant="primary">
                <x-icon name="solar:shield-check-line-duotone" size="1rem" />
                DiaPredict Access
            </x-ui.badge>
            <h1 class="mt-5 text-4xl font-bold tracking-tight text-ink-900">Masuk ke dashboard kesehatan yang lebih rapi.</h1>
            <p class="mt-4 max-w-md text-base leading-7 text-ink-500">
                Pantau prediksi, artikel, edukasi, pengguna, dan klinik dalam pengalaman yang konsisten untuk semua role.
            </p>
        </section>

        <x-ui.card padding="p-8">
            <div class="mb-6">
                <p class="text-xs font-bold uppercase tracking-[0.32em] text-brand-600">Masuk</p>
                <h2 class="mt-2 text-2xl font-bold text-ink-900">Login ke sistem</h2>
                <p class="mt-2 text-sm leading-6 text-ink-500">Gunakan akun yang sudah terdaftar untuk mengakses dashboard sesuai role.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-2xl bg-danger-50 px-4 py-3 text-sm font-semibold text-danger-600">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <x-form.input label="Email" name="email" type="email" required />
                <x-form.input label="Password" name="password" type="password" required />

                <div class="flex items-center justify-between gap-3 pt-2">
                    <x-ui.button type="submit">
                        <x-icon name="solar:login-2-line-duotone" size="1rem" />
                        Login
                    </x-ui.button>
                    <a href="{{ route('register') }}" wire:navigate class="text-sm font-bold text-brand-700 hover:text-brand-900">
                        Buat akun
                    </a>
                </div>
            </form>
        </x-ui.card>
    </div>
@endsection
