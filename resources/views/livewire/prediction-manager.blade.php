<div class="grid gap-6 xl:grid-cols-2">
    <!-- Form Prediksi -->
    <div class="space-y-5">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Form Prediksi</p>
                    <h2 class="mt-1 text-2xl font-semibold text-slate-900">Masukkan data kesehatan</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Isi semua data berikut agar sistem dapat
                        mengirimkan prediksi risiko diabetes ke API Python dan menyimpan hasilnya ke riwayat.</p>
                </div>
                <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">Wajib diisi</span>
            </div>

            @if (session('status'))
                <div class="mt-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('status') }}</div>
            @endif

            @if ($lastPredictionResult)
                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Hasil Prediksi
                            </div>
                            <div class="mt-1 text-xl font-semibold text-slate-900">
                                {{ match ($lastPredictionResult) {
                                    'diabetes' => 'Diabetes',
                                    'prediabetes' => 'Prediabetes',
                                    default => 'Normal',
                                } }}
                            </div>
                        </div>

                        <span
                            class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $lastPredictionResult === 'diabetes' ? 'bg-rose-50 text-rose-700' : ($lastPredictionResult === 'prediabetes' ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700') }}">Edukasi
                            otomatis</span>
                    </div>

                    @if ($lastEducation)
                        <div class="mt-4 border-t border-slate-200 pt-4">
                            <div class="text-sm font-semibold text-slate-900">{{ $lastEducation['title'] }}</div>
                            <div class="mt-2 text-sm leading-6 text-slate-600">{!! nl2br(e(strip_tags($lastEducation['content']))) !!}</div>
                        </div>
                    @else
                        <div class="mt-4 border-t border-slate-200 pt-4 text-sm text-slate-500">Belum ada edukasi
                            published untuk hasil ini.</div>
                    @endif
                </div>
            @endif

            <form wire:submit.prevent="submit" class="mt-6 grid gap-4 md:grid-cols-2">
                @if (auth()->user()?->role === 'petugas')
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Pasien</label>
                        <input wire:model.live="patient_name" type="text"
                            class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                            placeholder="Contoh: Budi Santoso" />
                        @error('patient_name')
                            <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Glucose</label>
                    <input wire:model.live="glucose" type="number" step="any"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Contoh: 120" />
                    @error('glucose')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Blood Pressure</label>
                    <input wire:model.live="blood_pressure" type="number" step="any"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Contoh: 72" />
                    @error('blood_pressure')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Insulin</label>
                    <input wire:model.live="insulin" type="number" step="any"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Contoh: 30" />
                    @error('insulin')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">BMI</label>
                    <input wire:model.live="bmi" type="number" step="any"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Contoh: 26.4" />
                    @error('bmi')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Age</label>
                    <input wire:model.live="age" type="number"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Contoh: 42" />
                    @error('age')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="md:col-span-2 flex flex-col gap-3 pt-2 sm:flex-row sm:items-center">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-60"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Mulai Prediksi</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                    <p class="text-sm text-slate-500">Hasil akan disimpan ke riwayat setelah proses selesai.</p>
                </div>
            </form>
        </div>

        @if ($loading)
            <div class="rounded-2xl bg-sky-50 px-4 py-3 text-sm font-medium text-sky-800">Sedang mengirim data ke API
                Python...</div>
        @endif
    </div>

    <!-- Riwayat Prediksi -->
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
        <div class="flex items-center justify-between gap-3">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Riwayat Prediksi</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-900">Daftar riwayat terbaru</h2>
            </div>
            <span
                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $histories->total() }}
                data</span>
        </div>

        <div class="mt-5 hidden md:block overflow-hidden rounded-2xl border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Tanggal</th>
                        <th class="px-4 py-3 font-semibold">Pasien / Pengguna</th>
                        <th class="px-4 py-3 font-semibold">Hasil</th>
                        <th class="px-4 py-3 font-semibold">Kemungkinan Risiko</th>
                        <th class="px-4 py-3 font-semibold">Usia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach ($histories as $history)
                        <tr wire:key="history-{{ $history->id }}">
                            <td class="px-4 py-3 text-slate-600">{{ $history->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-4 py-3 text-slate-600">
                                <div class="font-semibold text-slate-800">
                                    {{ $history->patient_name ?? $history->user?->name ?? 'Pengguna' }}</div>
                                @if ($history->inputBy)
                                    <div class="text-xs text-slate-500">Input oleh {{ $history->inputBy->name }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $history->result_badge_classes }}">
                                    {{ $history->result_label }}</span>
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
                    <div class="text-sm font-semibold text-slate-900">{{ $history->created_at->format('d M Y, H:i') }}
                    </div>
                    <div class="mt-1 text-sm text-slate-600">
                        {{ $history->patient_name ?? $history->user?->name ?? 'Pengguna' }}</div>
                    @if ($history->inputBy)
                        <div class="mt-1 text-xs text-slate-500">Input oleh {{ $history->inputBy->name }}</div>
                    @endif
                    <div class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $history->result_badge_classes }}">
                        {{ $history->result_label }}</div>
                    <div class="mt-3 text-sm text-slate-600">Kemungkinan Risiko:
                        {{ number_format((float) $history->probability * 100, 0) }}%</div>
                    <div class="mt-1 text-sm text-slate-600">Usia: {{ $history->age ?? '-' }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $histories->links() }}</div>
    </div>
</div>
