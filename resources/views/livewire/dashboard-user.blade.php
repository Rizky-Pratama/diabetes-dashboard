<div class="space-y-8">
    <x-ui.page-header eyebrow="Dashboard Pengguna" :title="'Halo, ' . auth()->user()->name"
        description="Lihat hasil prediksi terakhir, riwayat pribadi, dan artikel edukasi kesehatan." class="mb-0">
        <x-slot:action>
            <a href="{{ route('prediction') }}" wire:navigate>
                <x-ui.button>
                    <x-icon name="solar:pulse-line-duotone" size="1rem" />
                    Mulai Prediksi
                </x-ui.button>
            </a>
        </x-slot:action>
    </x-ui.page-header>

    <section class="grid gap-6 xl:grid-cols-3">
        <x-ui.card class="xl:col-span-2">
            <h2 class="text-lg font-bold text-ink-900">Hasil prediksi terakhir</h2>

            @if ($last)
                <div class="mt-4 rounded-3xl border border-ink-100 bg-ink-50 p-5">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-semibold text-ink-500">Hasil Prediksi</p>
                            <p class="mt-2 text-3xl font-bold text-ink-900">{{ $last->result_label }}</p>
                            <p class="mt-1 text-sm text-ink-500">{{ $last->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="rounded-3xl bg-white px-5 py-4 text-center shadow-sm">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-ink-400">Probabilitas</p>
                            <p class="mt-2 text-4xl font-bold text-brand-600">
                                {{ number_format((float) $last->probability * 100, 0) }}%
                            </p>
                        </div>
                    </div>

                    @if ($education)
                        <div class="mt-5 border-t border-ink-100 pt-4">
                            <x-ui.badge :variant="match ($last->result) {
                                'diabetes' => 'danger',
                                'prediabetes' => 'warning',
                                default => 'success',
                            }">
                                Edukasi {{ $last->result_label }}
                            </x-ui.badge>
                            <div class="mt-3 text-sm font-bold text-ink-900">{{ $education->title }}</div>
                            <x-content.quill-viewer :content="$education->content" class="mt-3" />
                        </div>
                    @endif
                </div>
            @else
                <x-ui.empty-state class="mt-4" icon="solar:pulse-line-duotone" title="Belum ada prediksi."
                    description="Tekan tombol Mulai Prediksi untuk memulai pemeriksaan mandiri." />
            @endif
        </x-ui.card>

        <x-ui.card>
            <h2 class="text-lg font-bold text-ink-900">Artikel edukasi</h2>
            <div class="mt-4 space-y-3">
                @forelse ($articles as $article)
                    <article class="rounded-2xl border border-ink-100 p-4">
                        <a href="{{ route('articles.show', $article) }}" wire:navigate
                            class="text-sm font-bold text-ink-900 transition hover:text-brand-700">
                            {{ $article->title }}
                        </a>
                        <p class="mt-2 line-clamp-3 text-sm leading-6 text-ink-500">
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}</p>
                        <a href="{{ route('articles.show', $article) }}" wire:navigate
                            class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-brand-700">
                            Baca detail
                            <x-icon name="solar:arrow-right-line-duotone" size="0.9rem" />
                        </a>
                    </article>
                @empty
                    <p class="text-sm text-ink-500">Belum ada artikel published.</p>
                @endforelse
            </div>
        </x-ui.card>
    </section>

    <x-ui.card>
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-ink-900">Riwayat prediksi pribadi</h2>
                <p class="text-sm text-ink-500">Riwayat hanya menampilkan prediksi milik akun Anda.</p>
            </div>
            <x-ui.badge variant="neutral">{{ $histories->count() }} data</x-ui.badge>
        </div>

        <div class="mt-5 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($histories as $history)
                <div class="rounded-2xl border border-ink-100 p-4">
                    <div class="text-sm font-bold text-ink-900">{{ $history->created_at->format('d M Y, H:i') }}</div>
                    <div class="mt-2">
                        <x-ui.badge :variant="match ($history->result) {
                            'diabetes' => 'danger',
                            'prediabetes' => 'warning',
                            default => 'success',
                        }">
                            {{ $history->result_label }}
                        </x-ui.badge>
                    </div>
                    <div class="mt-3 text-sm text-ink-500">Probabilitas:
                        {{ number_format((float) $history->probability * 100, 0) }}%</div>
                </div>
            @empty
                <div class="md:col-span-2 xl:col-span-3">
                    <x-ui.empty-state title="Riwayat pribadi masih kosong." icon="solar:history-line-duotone" />
                </div>
            @endforelse
        </div>
    </x-ui.card>
</div>
