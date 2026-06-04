<div class="space-y-6">
    <x-ui.page-header eyebrow="Modul Klinik" title="Kelola data klinik"
        description="Tambah, ubah, atau hapus klinik dengan tampilan form yang ringkas dan tabel yang mudah dipindai."
        class="mb-0">
        <x-slot:action>
            <x-ui.badge variant="primary">{{ $clinics->total() }} klinik</x-ui.badge>
        </x-slot:action>
    </x-ui.page-header>

    @if (session('status'))
        <div class="rounded-2xl bg-health-50 px-4 py-3 text-sm font-semibold text-health-600">
            {{ session('status') }}
        </div>
    @endif

    <section class="grid gap-6 xl:grid-cols-5">
        <x-ui.card class="xl:col-span-2">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-ink-900">{{ $editingId ? 'Ubah Klinik' : 'Klinik Baru' }}</h2>
                    <p class="mt-1 text-sm text-ink-500">Data klinik dipakai untuk membatasi histori petugas.</p>
                </div>
                <x-icon name="solar:hospital-line-duotone" class="text-brand-500" size="1.6rem" />
            </div>

            <div class="mt-5 space-y-5">
                <x-form.input label="Nama Klinik" name="nama_klinik" model="nama_klinik" placeholder="Nama klinik"
                    required />

                <div>
                    <label class="mb-2 block text-sm font-semibold text-ink-700">Logo</label>
                    <input wire:model="logoFile" type="file" accept="image/*"
                        class="w-full rounded-2xl border border-dashed border-ink-200 bg-white px-4 py-3 text-sm text-ink-600 outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-ink-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white focus:border-brand-400 focus:ring-4 focus:ring-brand-100" />
                    @if ($logoFile)
                        <img src="{{ $logoFile->temporaryUrl() }}" alt="Pratinjau logo"
                            class="mt-3 h-28 w-28 rounded-2xl border border-ink-100 object-cover" />
                    @elseif ($logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($logo) }}"
                            alt="Logo klinik" class="mt-3 h-28 w-28 rounded-2xl border border-ink-100 object-cover" />
                    @endif
                </div>

                <x-form.textarea label="Alamat" name="alamat" model="alamat" rows="4" placeholder="Alamat klinik"
                    required />
                <x-form.input label="Telepon" name="telepon" model="telepon" placeholder="08xxxx" required />
                <x-form.input label="Email" name="email" type="email" model="email" placeholder="email@klinik.com"
                    required />

                <div class="flex flex-wrap gap-3 border-t border-ink-100 pt-5">
                    @if ($editingId)
                        <x-ui.button type="button" wire:click="updateClinic">
                            <x-icon name="solar:diskette-line-duotone" size="1rem" />
                            Simpan Perubahan
                        </x-ui.button>
                        <x-ui.button type="button" variant="light" wire:click="resetForm">Batal</x-ui.button>
                    @else
                        <x-ui.button type="button" wire:click="createClinic">
                            <x-icon name="solar:add-circle-line-duotone" size="1rem" />
                            Simpan Klinik
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </x-ui.card>

        <x-ui.card class="xl:col-span-3">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-ink-900">Daftar Klinik</h2>
                    <p class="text-sm text-ink-500">Kartu di mobile, tabel ringkas di desktop.</p>
                </div>
                <x-ui.badge variant="neutral">{{ $clinics->count() }} tampil</x-ui.badge>
            </div>

            <div class="mt-5 hidden overflow-hidden rounded-2xl border border-ink-100 lg:block">
                <table class="min-w-full divide-y divide-ink-100 text-sm">
                    <thead class="bg-ink-50 text-left text-ink-500">
                        <tr>
                            <th class="px-4 py-3 font-bold">Nama</th>
                            <th class="px-4 py-3 font-bold">Kontak</th>
                            <th class="px-4 py-3 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-100 bg-white">
                        @forelse ($clinics as $clinic)
                            <tr wire:key="clinic-row-{{ $clinic->id }}">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($clinic->logo)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($clinic->logo) }}"
                                                alt="Logo {{ $clinic->nama_klinik }}"
                                                class="h-12 w-12 rounded-2xl border border-ink-100 object-cover" />
                                        @else
                                            <div
                                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-500">
                                                <x-icon name="solar:hospital-line-duotone" size="1.3rem" />
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-ink-900">{{ $clinic->nama_klinik }}</div>
                                            <div class="text-xs text-ink-500">
                                                {{ \Illuminate\Support\Str::limit($clinic->alamat, 80) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-ink-600">{{ $clinic->telepon }}<br>{{ $clinic->email }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <x-ui.button type="button" size="sm" variant="soft"
                                            wire:click="editClinic({{ $clinic->id }})">Edit</x-ui.button>
                                        <x-ui.button type="button" size="sm" variant="danger"
                                            wire:click="deleteClinic({{ $clinic->id }})">Hapus</x-ui.button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-10">
                                    <x-ui.empty-state title="Belum ada klinik." icon="solar:hospital-line-duotone" />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5 grid gap-3 lg:hidden">
                @forelse ($clinics as $clinic)
                    <div wire:key="clinic-card-{{ $clinic->id }}" class="rounded-2xl border border-ink-100 p-4">
                        <div class="flex items-center gap-3">
                            @if ($clinic->logo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($clinic->logo) }}"
                                    alt="Logo {{ $clinic->nama_klinik }}"
                                    class="h-14 w-14 rounded-2xl border border-ink-100 object-cover" />
                            @else
                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-500">
                                    <x-icon name="solar:hospital-line-duotone" size="1.5rem" />
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-bold text-ink-900">{{ $clinic->nama_klinik }}</div>
                                <p class="mt-1 text-sm leading-6 text-ink-500">
                                    {{ \Illuminate\Support\Str::limit($clinic->alamat, 120) }}</p>
                            </div>
                        </div>
                        <div class="mt-3 text-sm text-ink-600">{{ $clinic->telepon }} · {{ $clinic->email }}</div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <x-ui.button type="button" size="sm" variant="soft"
                                wire:click="editClinic({{ $clinic->id }})">Edit</x-ui.button>
                            <x-ui.button type="button" size="sm" variant="danger"
                                wire:click="deleteClinic({{ $clinic->id }})">Hapus</x-ui.button>
                        </div>
                    </div>
                @empty
                    <x-ui.empty-state title="Belum ada klinik." icon="solar:hospital-line-duotone" />
                @endforelse
            </div>

            <div class="mt-6">{{ $clinics->links() }}</div>
        </x-ui.card>
    </section>
</div>
