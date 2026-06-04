@extends('layouts.app')

@section('content')
    @auth
        @if (auth()->user()->role === 'admin')
            @livewire(\App\Http\Livewire\DashboardAdmin::class)
        @elseif (auth()->user()->role === 'petugas')
            @livewire(\App\Http\Livewire\DashboardClinic::class)
        @else
            @livewire(\App\Http\Livewire\DashboardUser::class)
        @endif
    @else
        <x-ui.empty-state icon="solar:login-2-line-duotone" title="Silakan login untuk melihat dashboard."
            description="Dashboard DiaPredict menyesuaikan tampilan berdasarkan role pengguna." />
    @endauth
@endsection
