<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'DiaPredict') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    @livewireStyles
</head>

<body class="min-h-screen bg-ink-50 font-sans text-ink-900 antialiased">
    <div
        class="pointer-events-none fixed inset-x-0 top-0 -z-10 h-80 bg-[radial-gradient(circle_at_top_left,#dff5ff,transparent_36%),linear-gradient(180deg,#ffffff_0%,#f8fafc_68%)]">
    </div>

    @include('layouts.partials.navbar')

    <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot }}
        @endif
    </main>

    @stack('scripts')
    <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js" defer></script>
    @livewireScripts
</body>

</html>
