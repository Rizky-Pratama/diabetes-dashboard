<div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
    <div class="flex items-center justify-between gap-3">
        <div>
            <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Riwayat Prediksi</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">Daftar riwayat terbaru</h2>
        </div>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $histories->total() }}
            data</span>
    </div>

    <div class="mt-5 hidden md:block overflow-hidden rounded-2xl border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-4 py-3 font-semibold">Tanggal</th>
                    <th class="px-4 py-3 font-semibold">Hasil</th>
                    <th class="px-4 py-3 font-semibold">Kemungkinan Risiko</th>
                    <th class="px-4 py-3 font-semibold">Usia</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @foreach ($histories as $history)
                    <tr wire:key="history-{{ $history->id }}">
                        <td class="px-4 py-3 text-slate-600">{{ $history->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $history->result === 'Risiko Diabetes' ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">{{ $history->result ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ number_format((float) $history->probability * 100, 0) }}%</td>
                        <td class="px-4 py-3 text-slate-600">{{ $history->age ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5 grid gap-3 md:hidden">
        @foreach ($histories as $history)
            <div wire:key="history-card-{{ $history->id }}" class="rounded-2xl border border-slate-200 p-4">
                <div class="text-sm font-semibold text-slate-900">{{ $history->created_at->format('d M Y, H:i') }}</div>
                <div
                    class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $history->result === 'Risiko Diabetes' ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                    {{ $history->result ?? 'N/A' }}</div>
                <div class="mt-3 text-sm text-slate-600">Kemungkinan Risiko:
                    {{ number_format((float) $history->probability * 100, 0) }}%</div>
                <div class="mt-1 text-sm text-slate-600">Usia: {{ $history->age ?? '-' }}</div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $histories->links() }}</div>
</div>
