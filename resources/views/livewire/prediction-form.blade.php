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

        <form wire:submit.prevent="submit" class="mt-6 grid gap-4 md:grid-cols-2">
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
