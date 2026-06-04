@extends('layouts.app')

@section('content')
    <div class="space-y-16 pb-10">
        <section
            class="relative overflow-hidden rounded-[2rem] border border-brand-100 bg-white px-6 py-10 shadow-sm sm:px-10 lg:px-12">
            <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr]">
                <div>
                    <x-ui.badge variant="primary">
                        <x-icon name="solar:pulse-line-duotone" size="1rem" />
                        Prediksi Diabetes Berbasis AI
                    </x-ui.badge>

                    <h1 class="mt-6 max-w-3xl text-4xl font-bold tracking-tight text-ink-900 sm:text-5xl">
                        DiaPredict
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-7 text-ink-500 sm:text-lg">
                        Pantau risiko diabetes sejak dini dengan alur prediksi yang sederhana, edukasi otomatis, dan
                        dashboard yang mudah dipahami untuk pengguna, petugas klinik, serta admin.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('prediction') }}" wire:navigate>
                                <x-ui.button size="lg">
                                    <x-icon name="solar:play-circle-line-duotone" size="1.15rem" />
                                    Mulai Prediksi
                                </x-ui.button>
                            </a>
                            <a href="{{ route('dashboard') }}" wire:navigate>
                                <x-ui.button variant="light" size="lg">
                                    <x-icon name="solar:chart-square-line-duotone" size="1.15rem" />
                                    Lihat Dashboard
                                </x-ui.button>
                            </a>
                        @else
                            <a href="{{ route('register') }}" wire:navigate>
                                <x-ui.button size="lg">
                                    <x-icon name="solar:user-plus-rounded-line-duotone" size="1.15rem" />
                                    Daftar Gratis
                                </x-ui.button>
                            </a>
                            <a href="{{ route('login') }}" wire:navigate>
                                <x-ui.button variant="light" size="lg">
                                    <x-icon name="solar:login-2-line-duotone" size="1.15rem" />
                                    Masuk
                                </x-ui.button>
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="rounded-[2rem] border border-ink-100 bg-ink-50 p-5">
                    <div class="grid gap-4">
                        <div class="rounded-3xl bg-white p-5 shadow-sm">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-ink-500">Hasil Prediksi</p>
                                    <p class="mt-2 text-3xl font-bold text-brand-700">Prediabetes</p>
                                </div>
                                <div class="rounded-2xl bg-alert-50 p-3 text-alert-600">
                                    <x-icon name="solar:danger-triangle-line-duotone" size="1.8rem" />
                                </div>
                            </div>
                            <div class="mt-5 h-3 overflow-hidden rounded-full bg-ink-100">
                                <div class="h-full w-7/12 rounded-full bg-brand-500"></div>
                            </div>
                            <p class="mt-3 text-sm text-ink-500">Edukasi otomatis membantu pengguna memahami langkah
                                berikutnya.</p>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-3">
                            <div class="rounded-3xl bg-white p-4 shadow-sm">
                                <x-icon name="solar:dropper-3-line-duotone" class="text-brand-500" size="1.4rem" />
                                <p class="mt-3 text-xs font-semibold text-ink-500">Glukosa</p>
                                <p class="text-xl font-bold text-ink-900">120</p>
                            </div>
                            <div class="rounded-3xl bg-white p-4 shadow-sm">
                                <x-icon name="solar:heart-pulse-line-duotone" class="text-health-600" size="1.4rem" />
                                <p class="mt-3 text-xs font-semibold text-ink-500">BMI</p>
                                <p class="text-xl font-bold text-ink-900">26.4</p>
                            </div>
                            <div class="rounded-3xl bg-white p-4 shadow-sm">
                                <x-icon name="solar:user-id-line-duotone" class="text-danger-500" size="1.4rem" />
                                <p class="mt-3 text-xs font-semibold text-ink-500">Usia</p>
                                <p class="text-xl font-bold text-ink-900">42</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ([['icon' => 'solar:dropper-3-line-duotone', 'title' => 'Glukosa', 'copy' => 'Parameter utama kadar gula darah.'], ['icon' => 'solar:heart-pulse-line-duotone', 'title' => 'Tekanan Darah', 'copy' => 'Kondisi tekanan darah diastolik.'], ['icon' => 'solar:stethoscope-line-duotone', 'title' => 'Insulin', 'copy' => 'Indikasi sensitivitas insulin.'], ['icon' => 'solar:scale-line-duotone', 'title' => 'BMI', 'copy' => 'Indeks massa tubuh pengguna.'], ['icon' => 'solar:user-id-line-duotone', 'title' => 'Usia', 'copy' => 'Faktor risiko berdasarkan umur.']] as $item)
                <x-ui.card hover>
                    <div class="rounded-2xl bg-brand-50 p-3 text-brand-600 w-fit">
                        <x-icon :name="$item['icon']" size="1.35rem" />
                    </div>
                    <h3 class="mt-4 text-base font-bold text-ink-900">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-ink-500">{{ $item['copy'] }}</p>
                </x-ui.card>
            @endforeach
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            @foreach ([['icon' => 'solar:clipboard-list-line-duotone', 'title' => 'Masukkan Data', 'copy' => 'Isi parameter kesehatan secara mandiri atau dibantu petugas klinik.'], ['icon' => 'solar:cpu-bolt-line-duotone', 'title' => 'Analisis Instan', 'copy' => 'Sistem mengirim data ke layanan prediksi dan menyimpan audit trail.'], ['icon' => 'solar:notebook-bookmark-line-duotone', 'title' => 'Edukasi Otomatis', 'copy' => 'Konten edukasi tampil dinamis sesuai hasil normal, prediabetes, atau diabetes.']] as $step)
                <x-ui.card hover>
                    <div class="flex items-start gap-4">
                        <div class="rounded-2xl bg-brand-50 p-3 text-brand-600">
                            <x-icon :name="$step['icon']" size="1.5rem" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-ink-900">{{ $step['title'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-ink-500">{{ $step['copy'] }}</p>
                        </div>
                    </div>
                </x-ui.card>
            @endforeach
        </section>

        <section class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.32em] text-brand-600">Artikel Kesehatan</p>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight text-ink-900">Edukasi terbaru</h2>
                    <p class="mt-2 text-sm leading-6 text-ink-500">Konten kesehatan global yang mudah dibaca.</p>
                </div>
                <a href="{{ route('articles.index') }}" wire:navigate>
                    <x-ui.button variant="soft">
                        Lihat Semua Artikel
                        <x-icon name="solar:arrow-right-line-duotone" size="1rem" />
                    </x-ui.button>
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @forelse ($articles as $article)
                    <x-ui.card hover padding="p-0" class="overflow-hidden">
                        <a href="{{ route('articles.show', $article) }}" wire:navigate class="block">
                            <div class="aspect-video bg-brand-50">
                                @if ($article->thumbnail)
                                    <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-brand-500">
                                        <x-icon name="solar:document-text-line-duotone" size="3rem" />
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="p-6">
                            <x-ui.badge variant="primary">DiaPredict</x-ui.badge>
                            <h3 class="mt-3 text-lg font-bold leading-snug text-ink-900">
                                <a href="{{ route('articles.show', $article) }}" wire:navigate
                                    class="transition hover:text-brand-700">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-ink-500">
                                {{ Str::limit(strip_tags($article->content), 120) }}
                            </p>
                            <a href="{{ route('articles.show', $article) }}" wire:navigate
                                class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-brand-700">
                                Baca detail
                                <x-icon name="solar:arrow-right-line-duotone" size="1rem" />
                            </a>
                        </div>
                    </x-ui.card>
                @empty
                    <div class="md:col-span-3">
                        <x-ui.empty-state icon="solar:document-text-line-duotone" title="Belum ada artikel published."
                            description="Artikel terbaru akan tampil di sini setelah admin mempublikasikannya." />
                    </div>
                @endforelse
            </div>
        </section>

        <section class="rounded-[2rem] border border-brand-100 bg-brand-50 p-8 text-center sm:p-10">
            <h2 class="text-2xl font-bold tracking-tight text-ink-900">Siap memulai langkah hidup sehat?</h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-6 text-ink-600">
                DiaPredict bersifat edukatif dan prediktif. Konsultasikan hasil dengan tenaga kesehatan untuk diagnosis
                resmi.
            </p>
            <div class="mt-6">
                @auth
                    <a href="{{ route('prediction') }}" wire:navigate>
                        <x-ui.button>
                            Mulai Prediksi Sekarang
                            <x-icon name="solar:arrow-right-line-duotone" size="1rem" />
                        </x-ui.button>
                    </a>
                @else
                    <a href="{{ route('register') }}" wire:navigate>
                        <x-ui.button>
                            Daftar Gratis Sekarang
                            <x-icon name="solar:arrow-right-line-duotone" size="1rem" />
                        </x-ui.button>
                    </a>
                @endauth
            </div>
        </section>
    </div>
@endsection
