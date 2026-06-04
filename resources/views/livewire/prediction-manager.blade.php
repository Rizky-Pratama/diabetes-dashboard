<div class="space-y-6">
    <x-ui.card>
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.32em] text-brand-600">Form Prediksi</p>
            <h2 class="mt-2 text-xl font-bold text-ink-900">Masukkan data kesehatan</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-ink-500">
                Data akan dikirim ke API prediksi dan disimpan sebagai riwayat dengan audit trail yang jelas.
            </p>
        </div>

        @if (session('status'))
            <div class="mt-4 rounded-2xl bg-health-50 px-4 py-3 text-sm font-semibold text-health-600">
                {{ session('status') }}
            </div>
        @endif

        @if ($lastPredictionResult)
            <div class="mt-5 rounded-3xl border border-ink-100 bg-ink-50 p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-ink-400">Hasil Prediksi</p>
                        <p class="mt-2 text-3xl font-bold text-ink-900">
                            {{ match ($lastPredictionResult) {
                                'diabetes' => 'Diabetes',
                                'prediabetes' => 'Prediabetes',
                                default => 'Normal',
                            } }}
                        </p>
                    </div>

                    <x-ui.badge :variant="$lastPredictionResult === 'diabetes' ? 'danger' : ($lastPredictionResult === 'prediabetes' ? 'warning' : 'success')">
                        <x-icon name="solar:notebook-bookmark-line-duotone" size="1rem" />
                        Edukasi otomatis
                    </x-ui.badge>
                </div>

                @if ($lastEducation)
                    <div class="mt-5 border-t border-ink-100 pt-4">
                        <div class="text-sm font-bold text-ink-900">{{ $lastEducation['title'] }}</div>
                        <x-content.quill-viewer id="education-content" :content="$lastEducation['content']" class="mt-3" />
                    </div>
                @else
                    <p class="mt-5 border-t border-ink-100 pt-4 text-sm text-ink-500">
                        Belum ada edukasi published untuk hasil ini.
                    </p>
                @endif
            </div>
        @endif

        <form wire:submit.prevent="submit" class="mt-6 space-y-5">
            @if (auth()->user()?->role === 'petugas')
                <div>
                    <x-form.input label="Nama Pasien" name="patient_name" model="patient_name"
                        placeholder="Contoh: Budi Santoso" required />
                </div>
            @endif

            <div class="rounded-3xl border border-ink-100 bg-white p-4 sm:p-5">
                <div class="flex items-center gap-2">
                    <span class="rounded-2xl bg-ink-50 p-2 text-ink-600">
                        <x-icon name="solar:clipboard-list-line-duotone" size="1.25rem" />
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-ink-900">Parameter pemeriksaan</h3>
                        <p class="mt-1 text-sm leading-6 text-ink-500">
                            Data utama yang dipakai model prediksi bersama nilai BMI.
                        </p>
                    </div>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <x-form.input label="Glucose" name="glucose" type="number" step="any" model="glucose"
                        placeholder="Contoh: 120" required />
                    <x-form.input label="Blood Pressure" name="blood_pressure" type="number" step="any"
                        model="blood_pressure" placeholder="Contoh: 72" required />
                    <x-form.input label="Insulin" name="insulin" type="number" step="any" model="insulin"
                        placeholder="Contoh: 30" required />
                    <x-form.input label="Age" name="age" type="number" model="age" placeholder="Contoh: 42"
                        required />
                </div>
            </div>

            <div class="rounded-3xl border border-brand-100 bg-brand-50/60 p-4 sm:p-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="rounded-2xl bg-white p-2 text-brand-600 shadow-sm">
                                <x-icon name="solar:scale-line-duotone" size="1.25rem" />
                            </span>
                            <div>
                                <h3 class="text-base font-bold text-ink-900">Komposisi tubuh</h3>
                                <p class="mt-1 text-sm leading-6 text-ink-500">
                                    Masukkan BB dan TB, sistem menghitung BMI otomatis.
                                </p>
                            </div>
                        </div>
                    </div>
                    <x-ui.badge variant="primary">BMI tersimpan</x-ui.badge>
                </div>

                <div class="mt-5 grid gap-4 lg:grid-cols-[1fr_1fr_0.9fr]">
                    <x-form.input label="Berat Badan" name="weight" type="number" step="any" model="weight"
                        placeholder="Contoh: 68" helper="Satuan kilogram (kg)." required />
                    <x-form.input label="Tinggi Badan" name="height" type="number" step="any" model="height"
                        placeholder="Contoh: 165" helper="Satuan centimeter (cm)." required />

                    <div class="rounded-3xl border border-ink-100 bg-white p-4 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <label for="bmi" class="text-sm font-bold text-ink-700">BMI otomatis</label>
                            <x-icon name="solar:calculator-minimalistic-line-duotone" class="text-brand-500"
                                size="1.25rem" />
                        </div>
                        <input id="bmi" name="bmi" type="number" step="any" wire:model.live="bmi"
                            readonly required placeholder="0.0"
                            class="mt-3 w-full rounded-2xl border border-ink-100 bg-ink-50 px-4 py-3 text-2xl font-bold text-ink-900 outline-none placeholder:text-ink-300" />
                        <p class="mt-2 text-xs leading-5 text-ink-500">
                            Hanya nilai BMI ini yang masuk ke prediksi dan riwayat.
                        </p>
                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <x-ui.badge :variant="$this->bmiCategory['variant']">
                                {{ $this->bmiCategory['label'] }}
                            </x-ui.badge>
                            <span class="text-xs leading-5 text-ink-500">
                                {{ $this->bmiCategory['description'] }}
                            </span>
                        </div>
                        <div class="mt-4">
                            <div
                                class="relative h-2 rounded-full bg-gradient-to-r from-alert-300 via-health-400 to-danger-400">
                                <span class="absolute -top-1 h-4 w-1.5 rounded-full bg-ink-900 shadow-sm"
                                    style="left: {{ $this->bmiCategory['marker'] }}"></span>
                            </div>
                            <div class="mt-2 flex justify-between text-[11px] font-semibold text-ink-400">
                                <span>&lt;18.5</span>
                                <span>18.5-24.9</span>
                                <span>25-29.9</span>
                                <span>30+</span>
                            </div>
                        </div>
                        @error('bmi')
                            <p class="mt-2 text-xs font-medium text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div
                class="flex flex-col gap-3 border-t border-ink-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                <x-ui.button type="submit" wire:loading.attr="disabled">
                    <x-icon name="solar:play-circle-line-duotone" size="1rem" wire:loading.remove />
                    <span wire:loading.remove>Mulai Prediksi</span>
                    <x-icon name="solar:refresh-line-duotone" size="1rem" wire:loading />
                    <span wire:loading>Memproses...</span>
                </x-ui.button>
                <p class="text-sm text-ink-500">Hasil tersimpan otomatis setelah proses selesai.</p>
            </div>
        </form>
    </x-ui.card>

    @if ($loading)
        <div class="rounded-2xl bg-brand-50 px-4 py-3 text-sm font-semibold text-brand-700">
            Sedang mengirim data ke API Python...
        </div>
    @endif

    <x-ui.card>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.32em] text-brand-600">Riwayat Prediksi</p>
                <h2 class="mt-2 text-xl font-bold text-ink-900">Daftar riwayat terbaru</h2>
                <p class="mt-2 text-sm leading-6 text-ink-500">
                    Menampilkan {{ $histories->firstItem() ?? 0 }}-{{ $histories->lastItem() ?? 0 }} dari
                    {{ $histories->total() }} rekam prediksi, termasuk semua kolom utama dari database.
                </p>
            </div>
            <x-ui.badge variant="neutral">{{ $histories->total() }} data</x-ui.badge>
        </div>

        <div class="mt-5 hidden overflow-x-auto rounded-2xl border border-ink-100 md:block">
            <table class="w-full min-w-[72rem] divide-y divide-ink-100 text-sm">
                <colgroup>
                    <col class="w-[14%]">
                    <col class="w-[24%]">
                    <col class="w-[42%]">
                    <col class="w-[20%]">
                </colgroup>
                <thead class="bg-ink-50 text-left text-ink-500">
                    <tr>
                        <th class="px-4 py-3 font-bold">Rekam</th>
                        <th class="px-4 py-3 font-bold">Subjek & sumber</th>
                        <th class="px-4 py-3 font-bold">Data Kesehatan</th>
                        <th class="px-4 py-3 font-bold">Hasil</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100 bg-white">
                    @forelse ($histories as $history)
                        <tr wire:key="history-{{ $history->id }}" class="transition hover:bg-ink-50/60">
                            <td class="px-4 py-4 align-top">
                                <div class="font-bold text-ink-900">#{{ $history->id }}</div>
                                <div class="mt-1 text-xs leading-5 text-ink-500">
                                    Dibuat {{ $history->created_at?->format('d M Y, H:i') ?? '-' }}
                                </div>
                                <div class="text-xs leading-5 text-ink-400">
                                    Update {{ $history->updated_at?->format('d M Y, H:i') ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <div class="font-bold text-ink-900">
                                    {{ $history->patient_name ?? ($history->user?->name ?? 'Pengguna') }}
                                </div>
                                <div class="mt-2 grid gap-1 text-xs leading-5 text-ink-500">
                                    @if ($history->user)
                                        <div>User: {{ $history->user?->name ?? '-' }}</div>
                                    @endif
                                    @if ($history->patient_name)
                                        <div>Patient name: {{ $history->patient_name }}</div>
                                    @endif
                                    @if ($history->inputBy)
                                        <div>Input by: {{ $history->inputBy?->name ?? '-' }}</div>
                                    @endif
                                    @if ($history->clinic)
                                        <div>Klinik: {{ $history->clinic?->nama_klinik ?? '-' }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <div class="grid grid-cols-2 gap-2 xl:grid-cols-5">
                                    <div class="rounded-2xl bg-ink-50 px-3 py-2">
                                        <div class="text-[11px] font-bold uppercase text-ink-400">Glucose</div>
                                        <div class="mt-1 font-bold text-ink-900">
                                            {{ filled($history->glucose) ? number_format((float) $history->glucose, 2) : '-' }}
                                        </div>
                                    </div>
                                    <div class="rounded-2xl bg-ink-50 px-3 py-2">
                                        <div class="text-[11px] font-bold uppercase text-ink-400">Blood Pressure</div>
                                        <div class="mt-1 font-bold text-ink-900">
                                            {{ filled($history->blood_pressure) ? number_format((float) $history->blood_pressure, 2) : '-' }}
                                        </div>
                                    </div>
                                    <div class="rounded-2xl bg-ink-50 px-3 py-2">
                                        <div class="text-[11px] font-bold uppercase text-ink-400">Insulin</div>
                                        <div class="mt-1 font-bold text-ink-900">
                                            {{ filled($history->insulin) ? number_format((float) $history->insulin, 2) : '-' }}
                                        </div>
                                    </div>
                                    <div class="rounded-2xl bg-brand-50 px-3 py-2">
                                        <div class="text-[11px] font-bold uppercase text-brand-600">BMI</div>
                                        <div class="mt-1 font-bold text-ink-900">
                                            {{ filled($history->bmi) ? number_format((float) $history->bmi, 2) : '-' }}
                                        </div>
                                    </div>
                                    <div class="rounded-2xl bg-ink-50 px-3 py-2">
                                        <div class="text-[11px] font-bold uppercase text-ink-400">Age</div>
                                        <div class="mt-1 font-bold text-ink-900">{{ $history->age ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <x-ui.badge :variant="match ($history->result) {
                                    'diabetes' => 'danger',
                                    'prediabetes' => 'warning',
                                    default => 'success',
                                }">
                                    {{ $history->result_label }}
                                </x-ui.badge>
                                <div class="mt-2 text-xs font-semibold text-ink-400">
                                    Raw result: {{ $history->result ?? '-' }}
                                </div>
                                <div class="mt-3 max-w-52 rounded-2xl bg-ink-50 px-3 py-2">
                                    <div class="text-[11px] font-bold uppercase text-ink-400">Probability</div>
                                    <div class="mt-1 text-lg font-bold text-ink-900">
                                        {{ filled($history->probability) ? number_format((float) $history->probability * 100, 2) . '%' : '-' }}
                                    </div>
                                    <div class="mt-1 text-xs text-ink-400">
                                        Raw:
                                        {{ filled($history->probability) ? number_format((float) $history->probability, 4) : '-' }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10">
                                <x-ui.empty-state title="Belum ada riwayat prediksi."
                                    icon="solar:history-line-duotone" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5 grid gap-3 md:hidden">
            @forelse ($histories as $history)
                <div wire:key="history-card-{{ $history->id }}" class="rounded-2xl border border-ink-100 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-sm font-bold text-ink-900">
                                {{ $history->patient_name ?? ($history->user?->name ?? 'Pengguna') }}
                            </div>
                            <div class="mt-1 text-xs leading-5 text-ink-500">
                                #{{ $history->id }} - {{ $history->created_at?->format('d M Y, H:i') ?? '-' }}
                            </div>
                        </div>
                        <x-ui.badge :variant="match ($history->result) {
                            'diabetes' => 'danger',
                            'prediabetes' => 'warning',
                            default => 'success',
                        }">
                            {{ $history->result_label }}
                        </x-ui.badge>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <div class="rounded-2xl bg-ink-50 px-3 py-2">
                            <div class="text-[11px] font-bold uppercase text-ink-400">Glucose</div>
                            <div class="font-bold text-ink-900">
                                {{ filled($history->glucose) ? number_format((float) $history->glucose, 2) : '-' }}
                            </div>
                        </div>
                        <div class="rounded-2xl bg-ink-50 px-3 py-2">
                            <div class="text-[11px] font-bold uppercase text-ink-400">BP</div>
                            <div class="font-bold text-ink-900">
                                {{ filled($history->blood_pressure) ? number_format((float) $history->blood_pressure, 2) : '-' }}
                            </div>
                        </div>
                        <div class="rounded-2xl bg-ink-50 px-3 py-2">
                            <div class="text-[11px] font-bold uppercase text-ink-400">Insulin</div>
                            <div class="font-bold text-ink-900">
                                {{ filled($history->insulin) ? number_format((float) $history->insulin, 2) : '-' }}
                            </div>
                        </div>
                        <div class="rounded-2xl bg-brand-50 px-3 py-2">
                            <div class="text-[11px] font-bold uppercase text-brand-600">BMI</div>
                            <div class="font-bold text-ink-900">
                                {{ filled($history->bmi) ? number_format((float) $history->bmi, 2) : '-' }}
                            </div>
                        </div>
                        <div class="rounded-2xl bg-ink-50 px-3 py-2">
                            <div class="text-[11px] font-bold uppercase text-ink-400">Age</div>
                            <div class="font-bold text-ink-900">{{ $history->age ?? '-' }}</div>
                        </div>
                        <div class="rounded-2xl bg-ink-50 px-3 py-2">
                            <div class="text-[11px] font-bold uppercase text-ink-400">Probability</div>
                            <div class="font-bold text-ink-900">
                                {{ filled($history->probability) ? number_format((float) $history->probability * 100, 2) . '%' : '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 rounded-2xl border border-ink-100 p-3 text-xs leading-5 text-ink-500">
                        <div>Patient name: {{ $history->patient_name ?? '-' }}</div>
                        <div>User: {{ $history->user?->name ?? '-' }}</div>
                        <div>User ID: {{ $history->user_id ?? '-' }}</div>
                        <div>Input by: {{ $history->inputBy?->name ?? '-' }}
                            @if ($history->input_by)
                                <span class="text-ink-400">(#{{ $history->input_by }})</span>
                            @endif
                        </div>
                        <div>Klinik: {{ $history->clinic?->name ?? '-' }}
                            @if ($history->clinic_id)
                                <span class="text-ink-400">(#{{ $history->clinic_id }})</span>
                            @endif
                        </div>
                        <div>Raw result: {{ $history->result ?? '-' }}</div>
                        <div>Updated: {{ $history->updated_at?->format('d M Y, H:i') ?? '-' }}</div>
                    </div>
                </div>
            @empty
                <x-ui.empty-state title="Belum ada riwayat prediksi." icon="solar:history-line-duotone" />
            @endforelse
        </div>

        <div class="mt-6">{{ $histories->links() }}</div>
    </x-ui.card>
</div>
