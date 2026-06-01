<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="absolute inset-x-0 top-0 -z-10 h-64 bg-gradient-to-b from-sky-100 via-white to-slate-50"></div>

    <header class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 lg:px-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded-2xl bg-slate-900 px-3 py-2 text-white shadow-sm transition hover:bg-slate-800">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white/15 text-sm font-bold">D</span>
                    <span class="text-sm font-semibold tracking-wide">{{ config('app.name') }}</span>
                </a>

                @auth
                    <nav class="hidden items-center gap-2 lg:flex">
                        <a href="{{ route('dashboard') }}"
                            class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Dashboard</a>
                        <a href="{{ route('prediction') }}"
                            class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('prediction') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Prediksi</a>
                        <a href="{{ route('articles.index') }}"
                            class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('articles.index') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Artikel</a>
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('clinics.index') }}"
                                class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('clinics.index') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Klinik</a>
                            <a href="{{ route('users.index') }}"
                                class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('users.index') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Pengguna</a>
                        @endif
                    </nav>
                @endauth
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <div class="hidden text-right sm:block">
                        <div class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</div>
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ auth()->user()->role }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="rounded-full bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Login</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-7xl px-4 py-8 lg:px-6">
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot }}
        @endif
    </main>

    @livewireScripts
</body>

</html>
