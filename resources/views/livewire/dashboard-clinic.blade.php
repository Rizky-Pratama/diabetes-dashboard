<div class="space-y-8">
    <x-ui.page-header :logo="$data['clinic']->logo ?? null" eyebrow="Dashboard Petugas" :title="$data['clinic']->nama_klinik ?? config('app.name')"
        description="Pantau statistik prediksi dan riwayat pasien hanya untuk klinik Anda." class="mb-0">
        <x-slot:action>
            <a href="{{ route('prediction') }}" wire:navigate>
                <x-ui.button>
                    <x-icon name="solar:pulse-line-duotone" size="1rem" />
                    Mulai Prediksi
                </x-ui.button>
            </a>
        </x-slot:action>
    </x-ui.page-header>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-data.stat-card label="Total Prediksi Klinik" :value="$data['predictions']" icon="solar:pulse-line-duotone" />
        <x-data.stat-card label="Diabetes" :value="$data['diabetes_count']" icon="solar:danger-triangle-line-duotone"
            variant="danger" />
        <x-data.stat-card label="Prediabetes" :value="$data['prediabetes_count']" icon="solar:shield-warning-line-duotone"
            variant="warning" />
        <x-data.stat-card label="Normal" :value="$data['normal_count']" icon="solar:check-circle-line-duotone" variant="success" />
    </section>

    <x-ui.card>
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-ink-900">Riwayat prediksi terbaru</h2>
                <p class="text-sm text-ink-500">Hanya menampilkan data dari klinik ini.</p>
            </div>
            <x-ui.badge variant="neutral">{{ $data['recent_histories']->count() }} data terbaru</x-ui.badge>
        </div>

        <div class="mt-5 space-y-3">
            @forelse ($data['recent_histories'] as $history)
                <div class="rounded-2xl border border-ink-100 p-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="text-sm font-bold text-ink-900">
                                {{ $history->patient_name ?? ($history->user?->name ?? 'Pengguna') }}
                            </div>
                            @if ($history->inputBy)
                                <div class="mt-1 text-xs text-ink-500">Input oleh {{ $history->inputBy->name }}</div>
                            @endif
                            <div class="mt-1 text-xs text-ink-500">{{ $history->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
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
                <x-ui.empty-state title="Belum ada riwayat klinik." icon="solar:hospital-line-duotone" />
            @endforelse
        </div>
    </x-ui.card>
</div>
