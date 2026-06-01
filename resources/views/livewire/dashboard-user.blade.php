<div class="space-y-6">
    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Dashboard Pengguna</p>
                <h1 class="text-2xl font-semibold text-slate-900">Halo, {{ auth()->user()->name }}</h1>
                <p class="mt-1 text-sm text-slate-500">Lihat hasil prediksi terakhir, riwayat pribadi, dan artikel
                    edukasi.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('prediction') }}"
                    class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Mulai
                    Prediksi</a>
                <a href="#riwayat"
                    class="rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Lihat
                    Riwayat</a>
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-3">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 xl:col-span-2">
            <h2 class="text-lg font-semibold text-slate-900">Hasil prediksi terakhir</h2>
            @if ($last)
                <div class="mt-4 rounded-2xl border border-slate-200 p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="text-sm text-slate-500">Hasil Prediksi</div>
                            <div class="text-2xl font-semibold text-slate-900">{{ $last->result }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $last->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div
                            class="rounded-2xl {{ $last->result === 'Risiko Diabetes' ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }} px-4 py-3 text-center">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em]">Kemungkinan Risiko</div>
                            <div class="text-3xl font-semibold">
                                {{ number_format((float) $last->probability * 100, 0) }}%</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-4 rounded-2xl border border-dashed border-slate-300 p-6 text-sm text-slate-500">Belum ada
                    prediksi. Tekan tombol Mulai Prediksi untuk memulai.</div>
            @endif
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
            <h2 class="text-lg font-semibold text-slate-900">Artikel edukasi</h2>
            <div class="mt-4 space-y-3">
                @foreach ($articles as $article)
                    <article class="rounded-2xl border border-slate-200 p-4">
                        <div class="text-sm font-semibold text-slate-900">{{ $article->title }}</div>
                        <p class="mt-2 line-clamp-3 text-sm text-slate-500">
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="riwayat" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">Riwayat prediksi pribadi</h2>
                <p class="text-sm text-slate-500">Card sederhana agar mudah dibaca di mobile.</p>
            </div>
            <span
                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $histories->count() }}
                data</span>
        </div>

        <div class="mt-5 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($histories as $history)
                <div class="rounded-2xl border border-slate-200 p-4">
                    <div class="text-sm font-semibold text-slate-900">{{ $history->created_at->format('d M Y, H:i') }}
                    </div>
                    <div
                        class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $history->result === 'Risiko Diabetes' ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                        {{ $history->result }}</div>
                    <div class="mt-3 text-sm text-slate-500">Kemungkinan Risiko:
                        {{ number_format((float) $history->probability * 100, 0) }}%</div>
                </div>
            @endforeach
        </div>
    </section>
</div>
