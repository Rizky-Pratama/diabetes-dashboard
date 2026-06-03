<div class="space-y-6">
    <section class="grid gap-6 xl:grid-cols-5">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 xl:col-span-2">
            <h3 class="text-lg font-semibold text-slate-900">{{ $editingId ? 'Ubah Edukasi' : 'Edukasi Baru' }}</h3>

            @if (session('status'))
                <div class="mt-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('status') }}</div>
            @endif

            <div class="mt-4 space-y-4">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Tipe Hasil</label>
                    <select wire:model.live="result_type"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100">
                        <option value="normal">Normal</option>
                        <option value="prediabetes">Prediabetes</option>
                        <option value="diabetes">Diabetes</option>
                    </select>
                    @error('result_type')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
                    <input wire:model.live="title" type="text"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Contoh: Risiko Prediabetes" />
                    @error('title')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Konten</label>
                    <textarea wire:model.live="content" rows="7"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Tuliskan edukasi yang akan tampil sesuai hasil prediksi."></textarea>
                    @error('content')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
                    <select wire:model.live="status"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    @if ($editingId)
                        <button type="button" wire:click="updateEducationContent"
                            class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan
                            Perubahan</button>
                        <button type="button" wire:click="resetForm"
                            class="rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Batal</button>
                    @else
                        <button type="button" wire:click="createEducationContent"
                            class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan
                            Edukasi</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 xl:col-span-3">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Edukasi</h3>
                    <p class="text-sm text-slate-500">Konten published akan dipakai otomatis pada hasil prediksi.</p>
                </div>
                <span
                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $educationContents->total() }}
                    data</span>
            </div>

            <div class="mt-5 hidden lg:block overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Tipe</th>
                            <th class="px-4 py-3 font-semibold">Judul</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach ($educationContents as $educationContent)
                            <tr wire:key="education-row-{{ $educationContent->id }}">
                                <td class="px-4 py-4 font-semibold text-slate-700">
                                    {{ $educationContent->result_type_label }}</td>
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-slate-900">{{ $educationContent->title }}</div>
                                    <div class="text-xs text-slate-500">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($educationContent->content), 100) }}
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $educationContent->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($educationContent->status) }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button"
                                            wire:click="editEducationContent({{ $educationContent->id }})"
                                            class="rounded-full bg-sky-100 px-4 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-200">Edit</button>
                                        <button type="button"
                                            wire:click="deleteEducationContent({{ $educationContent->id }})"
                                            class="rounded-full bg-rose-100 px-4 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5 grid gap-3 lg:hidden">
                @foreach ($educationContents as $educationContent)
                    <div wire:key="education-card-{{ $educationContent->id }}"
                        class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                                    {{ $educationContent->result_type_label }}</div>
                                <div class="mt-1 text-sm font-semibold text-slate-900">{{ $educationContent->title }}
                                </div>
                                <p class="mt-2 text-sm text-slate-500">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($educationContent->content), 120) }}</p>
                            </div>
                            <span
                                class="rounded-full px-3 py-1 text-xs font-semibold {{ $educationContent->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($educationContent->status) }}</span>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <button type="button" wire:click="editEducationContent({{ $educationContent->id }})"
                                class="rounded-full bg-sky-100 px-4 py-2 text-xs font-semibold text-sky-700">Edit</button>
                            <button type="button" wire:click="deleteEducationContent({{ $educationContent->id }})"
                                class="rounded-full bg-rose-100 px-4 py-2 text-xs font-semibold text-rose-700">Hapus</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $educationContents->links() }}</div>
        </div>
    </section>
</div>
