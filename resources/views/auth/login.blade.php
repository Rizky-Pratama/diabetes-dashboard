@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200/70">
            <div class="mb-6">
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Masuk</p>
                <h1 class="mt-2 text-2xl font-semibold text-slate-900">Login ke sistem</h1>
                <p class="mt-2 text-sm text-slate-500">Gunakan akun yang sudah terdaftar untuk mengakses dashboard sesuai
                    role.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input type="email" name="email"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        required />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                    <input type="password" name="password"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        required />
                </div>
                <div class="flex items-center justify-between gap-3 pt-2">
                    <button
                        class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Login</button>
                    <a href="{{ route('register') }}" wire:navigate class="text-sm font-semibold text-sky-700 hover:text-sky-900">Buat
                        akun</a>
                </div>
            </form>
        </div>
    </div>
@endsection
