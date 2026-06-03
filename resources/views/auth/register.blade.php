@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200/70">
            <div class="mb-6">
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Registrasi</p>
                <h1 class="mt-2 text-2xl font-semibold text-slate-900">Buat akun baru</h1>
                <p class="mt-2 text-sm text-slate-500">Setelah daftar, sistem akan membawa Anda ke dashboard pengguna.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Name</label>
                    <input type="text" name="name"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        required />
                </div>
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
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        required />
                </div>
                <div class="flex items-center justify-between gap-3 pt-2">
                    <button
                        class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Register</button>
                    <a href="{{ route('login') }}" wire:navigate class="text-sm font-semibold text-sky-700 hover:text-sky-900">Sudah punya
                        akun?</a>
                </div>
            </form>
        </div>
    </div>
@endsection
