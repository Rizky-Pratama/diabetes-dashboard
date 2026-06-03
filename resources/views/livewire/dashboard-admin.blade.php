<div class="space-y-6">
    <section class="rounded-3xl bg-slate-900 px-6 py-8 text-white shadow-lg shadow-slate-200/60">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl space-y-3">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-300">Dashboard Admin</p>
                <h1 class="text-3xl font-semibold tracking-tight">Ringkasan sistem prediksi risiko diabetes</h1>
                <p class="text-sm leading-6 text-slate-300">Kelola klinik, pengguna, artikel, dan pantau hasil prediksi
                    dalam satu tampilan yang bersih dan mudah dibaca.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('clinics.index') }}" wire:navigate
                    class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">Kelola
                    Klinik</a>
                <a href="{{ route('users.index') }}" wire:navigate
                    class="rounded-full bg-sky-400 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-sky-300">Kelola
                    Pengguna</a>
                <a href="{{ route('education.index') }}" wire:navigate
                    class="rounded-full bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/20">Kelola
                    Edukasi</a>
            </div>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
            <div class="text-sm text-slate-500">Total Klinik</div>
            <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $data['clinics'] }}</div>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
            <div class="text-sm text-slate-500">Total Pengguna</div>
            <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $data['users'] }}</div>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
            <div class="text-sm text-slate-500">Total Prediksi</div>
            <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $data['predictions'] }}</div>
        </div>
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200/70">
            <div class="text-sm text-slate-500">Artikel & Edukasi</div>
            <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $data['articles'] }}</div>
            <div class="mt-1 text-xs text-slate-500">{{ $data['education_contents'] }} edukasi otomatis</div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-3">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 xl:col-span-2">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Riwayat prediksi terbaru</h2>
                    <p class="text-sm text-slate-500">Tampilan ringkas dan mudah dipindai.</p>
                </div>
                <span
                    class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">{{ $data['predictions'] }}
                    data</span>
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
                                <div class="text-xs text-slate-500">
                                    {{ $history->clinic?->nama_klinik ?? config('app.name') }} ·
                                    {{ $history->created_at->format('d M Y, H:i') }}</div>
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
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
            <h2 class="text-lg font-semibold text-slate-900">Statistik hasil</h2>
            <div class="mt-4 space-y-3">
                <div class="rounded-2xl bg-rose-50 p-4">
                    <div class="text-sm text-rose-700">Diabetes</div>
                    <div class="text-3xl font-semibold text-rose-900">{{ $data['diabetes_count'] }}</div>
                </div>
                <div class="rounded-2xl bg-amber-50 p-4">
                    <div class="text-sm text-amber-700">Prediabetes</div>
                    <div class="text-3xl font-semibold text-amber-900">{{ $data['prediabetes_count'] }}</div>
                </div>
                <div class="rounded-2xl bg-emerald-50 p-4">
                    <div class="text-sm text-emerald-700">Normal</div>
                    <div class="text-3xl font-semibold text-emerald-900">{{ $data['normal_count'] }}</div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Artikel terbaru</h3>
                <div class="mt-3 space-y-3">
                    @foreach ($data['recent_articles'] as $article)
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <div class="text-sm font-semibold text-slate-900">{{ $article->title }}</div>
                            <div class="mt-1 text-xs text-slate-500">Global · {{ ucfirst($article->status) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
