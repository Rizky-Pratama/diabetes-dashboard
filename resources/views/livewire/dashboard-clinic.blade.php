<div class="space-y-6">
    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center">
                    <img src="{{ Storage::url($data['clinic']->logo ?? 'logo.png') }}" alt="Logo"
                        class="h-full w-full object-cover" />
                </div>
                <div>
                    <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Dashboard Petugas</p>
                    <h1 class="text-2xl font-semibold text-slate-900">
                        {{ $data['clinic']->nama_klinik ?? config('app.name') }}</h1>
                    <p class="text-sm text-slate-500">Statistik prediksi dan riwayat klinik dalam satu tampilan
                        sederhana.</p>
                </div>
            </div>

            <a href="{{ route('prediction') }}" wire:navigate
                class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Mulai
                Prediksi</a>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
            <div class="text-sm text-slate-500">Total Prediksi Klinik</div>
            <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $data['predictions'] }}</div>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
            <div class="text-sm text-rose-600">Diabetes</div>
            <div class="mt-2 text-3xl font-semibold text-rose-700">{{ $data['diabetes_count'] }}</div>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
            <div class="text-sm text-amber-600">Prediabetes</div>
            <div class="mt-2 text-3xl font-semibold text-amber-700">{{ $data['prediabetes_count'] }}</div>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
            <div class="text-sm text-emerald-600">Normal</div>
            <div class="mt-2 text-3xl font-semibold text-emerald-700">{{ $data['normal_count'] }}</div>
        </div>
    </section>

    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Riwayat prediksi terbaru</h2>
                <p class="text-sm text-slate-500">Hanya data dari klinik ini.</p>
            </div>
            <span
                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $data['recent_histories']->count() }}
                data terbaru</span>
        </div>

        <div class="mt-5 space-y-3">
            @foreach ($data['recent_histories'] as $history)
                <div class="rounded-2xl border border-slate-200 p-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">
                                {{ $history->patient_name ?? $history->user?->name ?? 'Pengguna' }}</div>
                            @if ($history->inputBy)
                                <div class="text-xs text-slate-500">Input oleh {{ $history->inputBy->name }}</div>
                            @endif
                            <div class="text-xs text-slate-500">{{ $history->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="flex flex-wrap gap-2 text-xs font-semibold">
                            <span class="rounded-full {{ $history->result_badge_classes }} px-3 py-1">
                                {{ $history->result_label }}</span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-700">Kemungkinan Risiko:
                                {{ number_format((float) $history->probability * 100, 0) }}%</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
