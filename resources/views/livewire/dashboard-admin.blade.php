<div class="space-y-8">
    <x-ui.page-header eyebrow="Dashboard Admin" title="Ringkasan sistem DiaPredict"
        description="Kelola klinik, pengguna, artikel, edukasi, dan pantau seluruh hasil prediksi dari satu tempat."
        class="mb-0">
        <x-slot:action>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('education.index') }}" wire:navigate>
                    <x-ui.button variant="soft">
                        <x-icon name="solar:notebook-bookmark-line-duotone" size="1rem" />
                        Edukasi
                    </x-ui.button>
                </a>
                <a href="{{ route('users.index') }}" wire:navigate>
                    <x-ui.button>
                        <x-icon name="solar:users-group-rounded-line-duotone" size="1rem" />
                        Pengguna
                    </x-ui.button>
                </a>
            </div>
        </x-slot:action>
    </x-ui.page-header>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-data.stat-card label="Total Klinik" :value="$data['clinics']" icon="solar:hospital-line-duotone" />
        <x-data.stat-card label="Total Pengguna" :value="$data['users']" icon="solar:users-group-rounded-line-duotone"
            variant="neutral" />
        <x-data.stat-card label="Total Prediksi" :value="$data['predictions']" icon="solar:pulse-line-duotone" variant="primary" />
        <x-data.stat-card label="Artikel & Edukasi" :value="$data['articles']" :description="$data['education_contents'] . ' edukasi otomatis'"
            icon="solar:document-text-line-duotone" variant="success" />
    </section>

    <section class="grid gap-6 xl:grid-cols-3">
        <x-ui.card class="xl:col-span-2">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-ink-900">Riwayat prediksi terbaru</h2>
                    <p class="text-sm text-ink-500">Audit trail prediksi dari pengguna dan petugas klinik.</p>
                </div>
                <x-ui.badge variant="primary">{{ $data['predictions'] }} data</x-ui.badge>
            </div>

            <div class="mt-5 space-y-3">
                @forelse ($data['recent_histories'] as $history)
                    <div class="rounded-2xl border border-ink-100 p-4">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <div class="text-sm font-bold text-ink-900">
                                    {{ $history->patient_name ?? ($history->user?->name ?? 'Pengguna') }}
                                </div>
                                <div class="mt-1 text-xs text-ink-500">
                                    {{ $history->clinic?->nama_klinik ?? config('app.name') }} ·
                                    {{ $history->created_at->format('d M Y, H:i') }}
                                </div>
                                @if ($history->inputBy)
                                    <div class="mt-1 text-xs text-ink-500">Input oleh {{ $history->inputBy->name }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-2 text-xs font-semibold">
                                <x-ui.badge :variant="match ($history->result) {
                                    'diabetes' => 'danger',
                                    'prediabetes' => 'warning',
                                    default => 'success',
                                }">
                                    {{ $history->result_label }}
                                </x-ui.badge>
                                <x-ui.badge variant="neutral">
                                    {{ number_format((float) $history->probability * 100, 0) }}%
                                </x-ui.badge>
                            </div>
                        </div>
                    </div>
                @empty
                    <x-ui.empty-state title="Belum ada histori prediksi." icon="solar:pulse-line-duotone" />
                @endforelse
            </div>
        </x-ui.card>

        <div class="space-y-6">
            <x-ui.card>
                <h2 class="text-lg font-bold text-ink-900">Statistik hasil</h2>
                <div class="mt-4 space-y-3">
                    <div class="rounded-2xl bg-danger-50 p-4">
                        <div class="text-sm font-semibold text-danger-600">Diabetes</div>
                        <div class="mt-2 text-3xl font-bold text-danger-600">{{ $data['diabetes_count'] }}</div>
                    </div>
                    <div class="rounded-2xl bg-alert-50 p-4">
                        <div class="text-sm font-semibold text-alert-600">Prediabetes</div>
                        <div class="mt-2 text-3xl font-bold text-alert-600">{{ $data['prediabetes_count'] }}</div>
                    </div>
                    <div class="rounded-2xl bg-health-50 p-4">
                        <div class="text-sm font-semibold text-health-600">Normal</div>
                        <div class="mt-2 text-3xl font-bold text-health-600">{{ $data['normal_count'] }}</div>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </section>
</div>
