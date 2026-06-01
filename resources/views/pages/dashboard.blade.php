@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        @auth
            @if (auth()->user()->role === 'admin')
                @livewire(\App\Http\Livewire\DashboardAdmin::class)
            @elseif (auth()->user()->role === 'petugas')
                @livewire(\App\Http\Livewire\DashboardClinic::class)
            @else
                @livewire(\App\Http\Livewire\DashboardUser::class)
            @endif
        @else
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">Silakan login untuk melihat dashboard.</div>
        @endauth
    </div>
@endsection
