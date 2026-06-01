@extends('layouts.app')

@section('content')
<div class="space-y-24 py-6">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 px-6 py-16 text-white shadow-xl sm:px-12 sm:py-20 md:px-16">
        <!-- Decorative blobs -->
        <div class="absolute -right-16 -top-16 h-96 w-96 rounded-full bg-sky-500/10 blur-3xl"></div>
        <div class="absolute -bottom-16 -left-16 h-96 w-96 rounded-full bg-indigo-500/10 blur-3xl"></div>
        
        <div class="relative mx-auto max-w-3xl text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-500/10 px-4 py-1.5 text-xs font-semibold text-sky-300 ring-1 ring-inset ring-sky-500/20">
                <span class="h-1.5 w-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                Prediksi Diabetes Berbasis AI & Machine Learning
            </span>
            <h1 class="mt-6 text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl bg-gradient-to-r from-white via-slate-100 to-sky-200 bg-clip-text text-transparent">
                Pantau Risiko Diabetes Sejak Dini
            </h1>
            <p class="mt-6 text-lg leading-relaxed text-slate-300">
                DiaPredict membantu Anda memprediksi tingkat risiko diabetes secara instan menggunakan analisis cerdas. Terintegrasi dengan klinik terpercaya untuk tindak lanjut kesehatan Anda.
            </p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                @auth
                    <a href="{{ route('prediction') }}" class="group relative inline-flex items-center gap-2 overflow-hidden rounded-full bg-sky-500 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all hover:bg-sky-400 hover:shadow-sky-500/20 active:scale-95">
                        Mulai Prediksi
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="{{ route('dashboard') }}" class="rounded-full bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20 active:scale-95">
                        Lihat Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="group relative inline-flex items-center gap-2 overflow-hidden rounded-full bg-sky-500 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all hover:bg-sky-400 hover:shadow-sky-500/20 active:scale-95">
                        Daftar Akun Gratis
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="rounded-full bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/20 active:scale-95">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Medical Parameters Section -->
    <section class="space-y-12">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Indikator Kesehatan yang Kami Analisis</h2>
            <p class="mt-4 text-slate-600">Model cerdas kami mengkaji lima parameter utama untuk memprediksi tingkat probabilitas risiko diabetes Anda.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-5">
            <!-- Glucose -->
            <div class="group relative rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/50 transition-all hover:-translate-y-1 hover:shadow-md hover:ring-sky-500/20">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600 group-hover:bg-sky-500 group-hover:text-white transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Glukosa</h3>
                <p class="mt-2 text-xs text-slate-500 leading-relaxed">Konsentrasi glukosa plasma 2 jam dalam tes toleransi glukosa oral.</p>
            </div>

            <!-- Blood Pressure -->
            <div class="group relative rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/50 transition-all hover:-translate-y-1 hover:shadow-md hover:ring-sky-500/20">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600 group-hover:bg-rose-500 group-hover:text-white transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Tekanan Darah</h3>
                <p class="mt-2 text-xs text-slate-500 leading-relaxed">Tekanan darah diastolik (mmHg) mengukur kekuatan aliran darah saat jantung beristirahat.</p>
            </div>

            <!-- Insulin -->
            <div class="group relative rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/50 transition-all hover:-translate-y-1 hover:shadow-md hover:ring-sky-500/20">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Insulin</h3>
                <p class="mt-2 text-xs text-slate-500 leading-relaxed">Kadar insulin serum 2 jam (mu U/ml) membantu mendeteksi resistensi insulin.</p>
            </div>

            <!-- BMI -->
            <div class="group relative rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/50 transition-all hover:-translate-y-1 hover:shadow-md hover:ring-sky-500/20">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold text-slate-900">BMI</h3>
                <p class="mt-2 text-xs text-slate-500 leading-relaxed">Indeks Massa Tubuh (berat badan dalam kg / tinggi badan kuadrat dalam meter).</p>
            </div>

            <!-- Age -->
            <div class="group relative rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/50 transition-all hover:-translate-y-1 hover:shadow-md hover:ring-sky-500/20">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold text-slate-900">Umur</h3>
                <p class="mt-2 text-xs text-slate-500 leading-relaxed">Faktor usia mempengaruhi metabolisme tubuh dan tingkat kerentanan diabetes.</p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="rounded-3xl bg-slate-900/5 p-8 ring-1 ring-slate-900/10 sm:p-12">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900">Bagaimana DiaPredict Bekerja</h2>
            <p class="mt-4 text-slate-600">Alur sederhana dan aman untuk mendeteksi serta mengelola risiko diabetes Anda.</p>
        </div>

        <div class="mt-12 grid gap-8 md:grid-cols-3">
            <div class="relative flex flex-col items-center text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-sky-500 font-bold text-white shadow-md ring-8 ring-sky-50">1</div>
                <h3 class="mt-6 text-lg font-semibold text-slate-900">Masukkan Data Kesehatan</h3>
                <p class="mt-2 text-sm text-slate-500">Isi form medis sederhana dengan parameter kesehatan yang Anda miliki secara mandiri.</p>
            </div>

            <div class="relative flex flex-col items-center text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-sky-500 font-bold text-white shadow-md ring-8 ring-sky-50">2</div>
                <h3 class="mt-6 text-lg font-semibold text-slate-900">Analisis Instan AI</h3>
                <p class="mt-2 text-sm text-slate-500">Layanan cerdas kami akan menganalisis data Anda secara real-time untuk memperkirakan probabilitas risiko.</p>
            </div>

            <div class="relative flex flex-col items-center text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-sky-500 font-bold text-white shadow-md ring-8 ring-sky-50">3</div>
                <h3 class="mt-6 text-lg font-semibold text-slate-900">Konsultasikan & Edukasi</h3>
                <p class="mt-2 text-sm text-slate-500">Hubungkan hasil prediksi ke klinik mitra dan pelajari tips pencegahan melalui artikel edukasi terpercaya.</p>
            </div>
        </div>
    </section>

    <!-- Latest Articles Section -->
    <section class="space-y-12">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Artikel Kesehatan Terbaru</h2>
                <p class="mt-2 text-slate-600">Pelajari tips dan informasi tepercaya langsung dari klinik mitra kami.</p>
            </div>
            <a href="{{ route('articles.index') }}" class="group inline-flex items-center gap-1 text-sm font-semibold text-sky-600 transition-all hover:text-sky-500">
                Lihat Semua Artikel
                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                <article class="flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/50 transition-all hover:-translate-y-1 hover:shadow-md">
                    <div class="aspect-video w-full bg-slate-100 overflow-hidden relative">
                        @if ($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-sky-50 text-sky-400">
                                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                        @endif
                        <span class="absolute right-3 top-3 rounded-full bg-white/90 backdrop-blur px-2.5 py-1 text-xs font-semibold text-slate-800 shadow-sm">
                            {{ $article->clinic->nama_klinik ?? 'DiaPredict' }}
                        </span>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <div class="text-xs text-slate-400">
                            {{ $article->created_at->translatedFormat('d M Y') }}
                        </div>
                        <h3 class="mt-2 text-lg font-semibold leading-snug text-slate-900 group-hover:text-sky-600">
                            {{ $article->title }}
                        </h3>
                        <p class="mt-3 text-sm text-slate-500 line-clamp-3">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>
                    </div>
                </article>
            @empty
                <!-- Fallback static articles to wow the user (premium content representation) -->
                <article class="flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/50">
                    <div class="aspect-video w-full bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center p-6 text-white text-center">
                        <h4 class="text-lg font-bold">Gaya Hidup Sehat & Pencegahan Diabetes</h4>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <div class="text-xs text-slate-400">01 Jun 2026</div>
                        <h3 class="mt-2 text-lg font-semibold leading-snug text-slate-900">
                            5 Kebiasaan Pagi Hari untuk Menjaga Kadar Gula Darah Stabil
                        </h3>
                        <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                            Pelajari rutinitas sederhana mulai dari pilihan sarapan kaya serat hingga hidrasi optimal untuk menghindari lonjakan glukosa mendadak.
                        </p>
                    </div>
                </article>

                <article class="flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/50">
                    <div class="aspect-video w-full bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center p-6 text-white text-center">
                        <h4 class="text-lg font-bold">Panduan Nutrisi Medis</h4>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <div class="text-xs text-slate-400">30 Mei 2026</div>
                        <h3 class="mt-2 text-lg font-semibold leading-snug text-slate-900">
                            Memahami Indeks Glikemik Makanan untuk Penderita Pradiabetes
                        </h3>
                        <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                            Mengenal perbedaan indeks glikemik rendah dan tinggi serta cara mengatur porsi makan karbohidrat kompleks demi menjaga kestabilan energi.
                        </p>
                    </div>
                </article>

                <article class="flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/50">
                    <div class="aspect-video w-full bg-gradient-to-br from-rose-400 to-amber-500 flex items-center justify-center p-6 text-white text-center">
                        <h4 class="text-lg font-bold">Aktivitas Fisik & Olahraga</h4>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <div class="text-xs text-slate-400">28 Mei 2026</div>
                        <h3 class="mt-2 text-lg font-semibold leading-snug text-slate-900">
                            Mengapa Latihan Kekuatan Otot Sangat Penting bagi Sensitivitas Insulin?
                        </h3>
                        <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                            Latihan beban ringan membantu otot menyerap glukosa tanpa bergantung sepenuhnya pada insulin. Simak tips memulai olahraga bagi pemula.
                        </p>
                    </div>
                </article>
            @endforelse
        </div>
    </section>

    <!-- Bottom CTA Section -->
    <section class="rounded-3xl bg-gradient-to-br from-indigo-900 to-slate-900 px-6 py-12 text-center text-white shadow-lg sm:px-12 sm:py-16">
        <div class="mx-auto max-w-2xl">
            <h2 class="text-3xl font-bold tracking-tight">Siap Memulai Langkah Hidup Sehat?</h2>
            <p class="mt-4 text-slate-300 leading-relaxed">
                Bergabunglah bersama ribuan pengguna lainnya yang telah mendeteksi secara dini dan mengambil langkah preventif untuk masa depan yang lebih sehat.
            </p>
            <div class="mt-8 flex justify-center">
                @auth
                    <a href="{{ route('prediction') }}" class="rounded-full bg-white px-6 py-3 text-sm font-semibold text-indigo-950 shadow-sm transition hover:bg-slate-100 active:scale-95">
                        Mulai Prediksi Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}" class="rounded-full bg-white px-6 py-3 text-sm font-semibold text-indigo-950 shadow-sm transition hover:bg-slate-100 active:scale-95">
                        Daftar Gratis Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-200/80 pt-8 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'DiaPredict') }}. Hak Cipta Dilindungi Undang-Undang.</p>
        <p class="mt-2">Layanan ini bersifat edukatif dan prediktif. Konsultasikan dengan tenaga kesehatan berlisensi untuk diagnosis medis resmi.</p>
    </footer>
</div>
@endsection
