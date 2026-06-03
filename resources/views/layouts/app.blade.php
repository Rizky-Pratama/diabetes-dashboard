<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    @livewireStyles
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="absolute inset-x-0 top-0 -z-10 h-64 bg-gradient-to-b from-sky-100 via-white to-slate-50"></div>

    <header x-data="{ open: false }" class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 lg:px-6">
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" wire:navigate>
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 w-max rounded-full object-cover" />
                </a>

                @auth
                    <nav class="hidden items-center gap-2 lg:flex">
                        <a href="{{ route('dashboard') }}" wire:navigate
                            class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Dashboard</a>
                        <a href="{{ route('prediction') }}" wire:navigate
                            class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('prediction') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Prediksi</a>
                        <a href="{{ route('articles.index') }}" wire:navigate
                            class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('articles.index') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Artikel</a>
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('education.index') }}" wire:navigate
                                class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('education.index') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Edukasi</a>
                            <a href="{{ route('clinics.index') }}" wire:navigate
                                class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('clinics.index') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Klinik</a>
                            <a href="{{ route('users.index') }}" wire:navigate
                                class="rounded-full px-4 py-2 text-sm font-medium {{ request()->routeIs('users.index') ? 'bg-sky-100 text-sky-900' : 'text-slate-600 hover:bg-slate-100' }}">Pengguna</a>
                        @endif
                    </nav>
                @endauth
            </div>

            <!-- Desktop Right Area -->
            <div class="hidden lg:flex lg:items-center lg:gap-3">
                @auth
                    <div class="text-right">
                        <div class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</div>
                        <div class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ auth()->user()->role }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="rounded-full bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" wire:navigate
                        class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Login</a>
                @endauth
            </div>

            <!-- Mobile Right Area (Hamburger / Login) -->
            <div class="flex items-center gap-3 lg:hidden">
                @auth
                    <button type="button" @click="open = !open"
                        class="relative inline-flex items-center justify-center rounded-xl p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300"
                        aria-controls="mobile-menu" :aria-expanded="open.toString()">
                        <span class="sr-only">Buka menu utama</span>
                        <!-- Menu open: "hidden", Menu closed: "block" -->
                        <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!-- Menu open: "block", Menu closed: "hidden" -->
                        <svg x-show="open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" style="display: none;">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M20 20L4 4m16 0L4 20" />
                        </svg>
                    </button>
                @else
                    <a href="{{ route('login') }}" wire:navigate
                        class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Login</a>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        @auth
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="border-t border-slate-200/60 bg-white/95 backdrop-blur px-4 py-3 lg:hidden" id="mobile-menu"
                style="display: none;">
                <div class="space-y-1 pb-3 pt-2">
                    <a href="{{ route('dashboard') }}" wire:navigate @click="open = false"
                        class="block rounded-xl px-4 py-2.5 text-base font-semibold {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-sky-900' : 'text-slate-600 hover:bg-slate-50' }}">Dashboard</a>
                    <a href="{{ route('prediction') }}" wire:navigate @click="open = false"
                        class="block rounded-xl px-4 py-2.5 text-base font-semibold {{ request()->routeIs('prediction') ? 'bg-sky-50 text-sky-900' : 'text-slate-600 hover:bg-slate-50' }}">Prediksi</a>
                    <a href="{{ route('articles.index') }}" wire:navigate @click="open = false"
                        class="block rounded-xl px-4 py-2.5 text-base font-semibold {{ request()->routeIs('articles.index') ? 'bg-sky-50 text-sky-900' : 'text-slate-600 hover:bg-slate-50' }}">Artikel</a>
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('education.index') }}" wire:navigate @click="open = false"
                            class="block rounded-xl px-4 py-2.5 text-base font-semibold {{ request()->routeIs('education.index') ? 'bg-sky-50 text-sky-900' : 'text-slate-600 hover:bg-slate-50' }}">Edukasi</a>
                        <a href="{{ route('clinics.index') }}" wire:navigate @click="open = false"
                            class="block rounded-xl px-4 py-2.5 text-base font-semibold {{ request()->routeIs('clinics.index') ? 'bg-sky-50 text-sky-900' : 'text-slate-600 hover:bg-slate-50' }}">Klinik</a>
                        <a href="{{ route('users.index') }}" wire:navigate @click="open = false"
                            class="block rounded-xl px-4 py-2.5 text-base font-semibold {{ request()->routeIs('users.index') ? 'bg-sky-50 text-sky-900' : 'text-slate-600 hover:bg-slate-50' }}">Pengguna</a>
                    @endif
                </div>
                <div class="border-t border-slate-100 pb-3 pt-4">
                    <div class="px-4">
                        <div class="text-base font-semibold text-slate-800">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-slate-500 uppercase tracking-wider">{{ auth()->user()->role }}
                        </div>
                    </div>
                    <div class="mt-3 px-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full rounded-xl bg-rose-50 px-4 py-2.5 text-left text-base font-semibold text-rose-700 transition hover:bg-rose-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    </header>

    <main class="mx-auto w-full max-w-7xl px-4 py-8 lg:px-6">
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot }}
        @endif
    </main>
    @stack('scripts')
    @livewireScripts
</body>

</html>
