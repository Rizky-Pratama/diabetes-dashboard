<header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-ink-100 bg-white/90 backdrop-blur-xl">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" wire:navigate class="flex items-center gap-3">
            <img src="{{ asset('logo.png') }}" alt="DiaPredict" class="h-10 w-auto">
        </a>

        @auth
            <div class="hidden items-center gap-1 lg:flex">
                <x-ui.nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="solar:chart-square-line-duotone">
                    Dashboard
                </x-ui.nav-link>
                <x-ui.nav-link href="{{ route('prediction') }}" :active="request()->routeIs('prediction')" icon="solar:pulse-line-duotone">
                    Prediksi
                </x-ui.nav-link>
                <x-ui.nav-link href="{{ route('articles.index') }}" :active="request()->routeIs('articles.*')"
                    icon="solar:document-text-line-duotone">
                    Artikel
                </x-ui.nav-link>
                @if (auth()->user()->role === 'admin')
                    <x-ui.nav-link href="{{ route('education.index') }}" :active="request()->routeIs('education.index')"
                        icon="solar:notebook-bookmark-line-duotone">
                        Edukasi
                    </x-ui.nav-link>
                    <x-ui.nav-link href="{{ route('clinics.index') }}" :active="request()->routeIs('clinics.index')" icon="solar:hospital-line-duotone">
                        Klinik
                    </x-ui.nav-link>
                    <x-ui.nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')"
                        icon="solar:users-group-rounded-line-duotone">
                        Pengguna
                    </x-ui.nav-link>
                @endif
            </div>
        @endauth

        <div class="flex items-center gap-3">
            @auth
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-bold leading-4 text-ink-900">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-ink-400">{{ auth()->user()->role }}
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
                    @csrf
                    <x-ui.button variant="danger" size="sm" type="submit">
                        <x-icon name="solar:logout-2-line-duotone" size="1rem" />
                        Logout
                    </x-ui.button>
                </form>
                <button type="button" @click="open = !open"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-2xl text-ink-600 hover:bg-ink-100 lg:hidden"
                    aria-controls="mobile-menu" :aria-expanded="open.toString()">
                    <span class="sr-only">Buka menu utama</span>
                    <x-icon name="solar:hamburger-menu-line-duotone" size="1.5rem" x-show="!open" />
                    <x-icon name="solar:close-circle-line-duotone" size="1.5rem" x-show="open" style="display: none;" />
                </button>
            @else
                <a href="{{ route('login') }}" wire:navigate>
                    <x-ui.button size="sm">
                        <x-icon name="solar:login-2-line-duotone" size="1rem" />
                        Login
                    </x-ui.button>
                </a>
            @endauth
        </div>
    </nav>

    @auth
        <div x-show="open" x-transition id="mobile-menu" class="border-t border-ink-100 bg-white px-4 py-4 lg:hidden"
            style="display: none;">
            <div class="grid gap-2">
                <x-ui.nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="solar:chart-square-line-duotone"
                    @click="open = false">
                    Dashboard
                </x-ui.nav-link>
                <x-ui.nav-link href="{{ route('prediction') }}" :active="request()->routeIs('prediction')" icon="solar:pulse-line-duotone"
                    @click="open = false">
                    Prediksi
                </x-ui.nav-link>
                <x-ui.nav-link href="{{ route('articles.index') }}" :active="request()->routeIs('articles.*')"
                    icon="solar:document-text-line-duotone" @click="open = false">
                    Artikel
                </x-ui.nav-link>
                @if (auth()->user()->role === 'admin')
                    <x-ui.nav-link href="{{ route('education.index') }}" :active="request()->routeIs('education.index')"
                        icon="solar:notebook-bookmark-line-duotone" @click="open = false">
                        Edukasi
                    </x-ui.nav-link>
                    <x-ui.nav-link href="{{ route('clinics.index') }}" :active="request()->routeIs('clinics.index')"
                        icon="solar:hospital-line-duotone" @click="open = false">
                        Klinik
                    </x-ui.nav-link>
                    <x-ui.nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')"
                        icon="solar:users-group-rounded-line-duotone" @click="open = false">
                        Pengguna
                    </x-ui.nav-link>
                @endif
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-4 border-t border-ink-100 pt-4">
                @csrf
                <x-ui.button variant="danger" type="submit" class="w-full">
                    <x-icon name="solar:logout-2-line-duotone" size="1rem" />
                    Logout
                </x-ui.button>
            </form>
        </div>
    @endauth
</header>
