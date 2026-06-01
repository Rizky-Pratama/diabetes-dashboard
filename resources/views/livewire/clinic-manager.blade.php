<div class="space-y-6">
    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Modul Klinik</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-900">Kelola data klinik</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Tambah, ubah, atau hapus klinik dengan form
                    yang sederhana dan card list yang mudah dipindai.</p>
            </div>
            <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">{{ $clinics->total() }}
                klinik</span>
        </div>

        @if (session('status'))
            <div class="mt-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('status') }}</div>
        @endif
    </section>

    <section class="grid gap-6 xl:grid-cols-5">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 xl:col-span-2">
            <h2 class="text-lg font-semibold text-slate-900">{{ $editingId ? 'Ubah Klinik' : 'Klinik Baru' }}</h2>
            <div class="mt-4 space-y-4">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Klinik</label>
                    <input wire:model.live="nama_klinik" type="text"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Nama klinik" />
                    @error('nama_klinik')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Logo</label>
                    <input wire:model="logoFile" type="file" accept="image/*"
                        class="w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100" />
                    @if ($logoFile)
                        <img src="{{ $logoFile->temporaryUrl() }}" alt="Pratinjau logo"
                            class="mt-3 h-28 w-28 rounded-2xl border border-slate-200 object-cover" />
                    @elseif ($logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($logo) }}"
                            alt="Logo klinik" class="mt-3 h-28 w-28 rounded-2xl border border-slate-200 object-cover" />
                    @endif
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Alamat</label>
                    <textarea wire:model.live="alamat" rows="4"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Alamat klinik"></textarea>
                    @error('alamat')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Telepon</label>
                    <input wire:model.live="telepon" type="text"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="08xxxx" />
                    @error('telepon')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input wire:model.live="email" type="email"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="email@klinik.com" />
                    @error('email')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    @if ($editingId)
                        <button type="button" wire:click="updateClinic"
                            class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan
                            Perubahan</button>
                        <button type="button" wire:click="resetForm"
                            class="rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Batal</button>
                    @else
                        <button type="button" wire:click="createClinic"
                            class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan
                            Klinik</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 xl:col-span-3">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Daftar Klinik</h2>
                    <p class="text-sm text-slate-500">Tampilan kartu di mobile, tabel ringkas di desktop.</p>
                </div>
                <span
                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $clinics->count() }}
                    tampil</span>
            </div>

            <div class="mt-5 hidden lg:block overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Nama</th>
                            <th class="px-4 py-3 font-semibold">Kontak</th>
                            <th class="px-4 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach ($clinics as $clinic)
                            <tr wire:key="clinic-row-{{ $clinic->id }}">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($clinic->logo)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($clinic->logo) }}"
                                                alt="Logo {{ $clinic->nama_klinik }}"
                                                class="h-12 w-12 rounded-2xl border border-slate-200 object-cover" />
                                        @else
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-xs font-semibold text-slate-500">
                                                N/A</div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-slate-900">{{ $clinic->nama_klinik }}</div>
                                            <div class="text-xs text-slate-500">
                                                {{ \Illuminate\Support\Str::limit($clinic->alamat, 80) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-slate-600">{{ $clinic->telepon }}<br>{{ $clinic->email }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" wire:click="editClinic({{ $clinic->id }})"
                                            class="rounded-full bg-sky-100 px-4 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-200">Edit</button>
                                        <button type="button" wire:click="deleteClinic({{ $clinic->id }})"
                                            class="rounded-full bg-rose-100 px-4 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5 grid gap-3 lg:hidden">
                @foreach ($clinics as $clinic)
                    <div wire:key="clinic-card-{{ $clinic->id }}" class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-center gap-3">
                            @if ($clinic->logo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($clinic->logo) }}"
                                    alt="Logo {{ $clinic->nama_klinik }}"
                                    class="h-14 w-14 rounded-2xl border border-slate-200 object-cover" />
                            @else
                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-xs font-semibold text-slate-500">
                                    N/A</div>
                            @endif
                            <div>
                                <div class="text-sm font-semibold text-slate-900">{{ $clinic->nama_klinik }}</div>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ \Illuminate\Support\Str::limit($clinic->alamat, 120) }}</p>
                            </div>
                        </div>
                        <div class="mt-3 text-sm text-slate-600">{{ $clinic->telepon }} · {{ $clinic->email }}</div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <button type="button" wire:click="editClinic({{ $clinic->id }})"
                                class="rounded-full bg-sky-100 px-4 py-2 text-xs font-semibold text-sky-700">Edit</button>
                            <button type="button" wire:click="deleteClinic({{ $clinic->id }})"
                                class="rounded-full bg-rose-100 px-4 py-2 text-xs font-semibold text-rose-700">Hapus</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $clinics->links() }}</div>
        </div>
    </section>
</div>
