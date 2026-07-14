<div class="space-y-6">
    <x-ui.page-header eyebrow="Modul Pengguna" title="Kelola pengguna dan role"
        description="Admin dapat menambah petugas klinik, mengatur role, dan menghubungkan pengguna dengan klinik."
        class="mb-0">
        <x-slot:action>
            <div class="flex flex-wrap items-center gap-3">
                <x-ui.badge variant="primary">{{ $users->total() }} pengguna</x-ui.badge>
                <a href="{{ route('report.users') }}" target="_blank">
                    <x-ui.button variant="secondary">
                        <x-icon name="solar:file-download-line-duotone" size="1rem" />
                        Ekspor PDF
                    </x-ui.button>
                </a>
            </div>
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
                    <h2 class="text-lg font-bold text-ink-900">{{ $editingId ? 'Ubah Pengguna' : 'Pengguna Baru' }}</h2>
                    <p class="mt-1 text-sm text-ink-500">Pilih role dan klinik untuk membatasi akses data.</p>
                </div>
                <x-icon name="solar:user-plus-rounded-line-duotone" class="text-brand-500" size="1.6rem" />
            </div>

            <div class="mt-5 space-y-5">
                <x-form.input label="Nama" name="name" model="name" placeholder="Nama pengguna" required />
                <x-form.input label="Email" name="email" type="email" model="email" placeholder="email@domain.com"
                    required />
                <x-form.input :label="$editingId ? 'Password (opsional)' : 'Password'" name="password" type="password" model="password" placeholder="Password"
                    :required="!$editingId" />
                <x-form.input label="Konfirmasi Password" name="password_confirmation" type="password"
                    model="password_confirmation" placeholder="Konfirmasi password" />

                <x-form.select label="Role" name="role" model="role" required>
                    <option value="pengguna">Pengguna</option>
                    <option value="petugas">Petugas</option>
                    <option value="admin">Admin</option>
                </x-form.select>

                <div wire:show="role === 'petugas'">
                    <x-form.select label="Klinik" name="clinic_id" model="clinic_id"
                        helper="Klinik wajib dipilih untuk role petugas.">
                        <option value="">- Tidak terhubung -</option>
                        @foreach ($clinics as $clinic)
                            <option value="{{ $clinic->id }}">{{ $clinic->nama_klinik }}</option>
                        @endforeach
                    </x-form.select>
                </div>

                <div class="flex flex-wrap gap-3 border-t border-ink-100 pt-5">
                    @if ($editingId)
                        <x-ui.button type="button" wire:click="updateUser">
                            <x-icon name="solar:diskette-line-duotone" size="1rem" />
                            Simpan Perubahan
                        </x-ui.button>
                        <x-ui.button type="button" variant="light" wire:click="resetForm">Batal</x-ui.button>
                    @else
                        <x-ui.button type="button" wire:click="createUser">
                            <x-icon name="solar:user-plus-rounded-line-duotone" size="1rem" />
                            Simpan Pengguna
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </x-ui.card>

        <x-ui.card class="xl:col-span-3">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-ink-900">Daftar Pengguna</h2>
                    <p class="text-sm text-ink-500">Role dan klinik ditampilkan agar mudah dicek.</p>
                </div>
                <x-ui.badge variant="neutral">{{ $users->count() }} tampil</x-ui.badge>
            </div>

            <div class="mt-5 hidden overflow-hidden rounded-2xl border border-ink-100 lg:block">
                <table class="min-w-full divide-y divide-ink-100 text-sm">
                    <thead class="bg-ink-50 text-left text-ink-500">
                        <tr>
                            <th class="px-4 py-3 font-bold">Nama</th>
                            <th class="px-4 py-3 font-bold">Role</th>
                            <th class="px-4 py-3 font-bold">Klinik</th>
                            <th class="px-4 py-3 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-100 bg-white">
                        @forelse ($users as $user)
                            <tr wire:key="user-row-{{ $user->id }}">
                                <td class="px-4 py-4">
                                    <div class="font-bold text-ink-900">{{ $user->name }}</div>
                                    <div class="text-xs text-ink-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <x-ui.badge variant="neutral">{{ ucfirst($user->role) }}</x-ui.badge>
                                </td>
                                <td class="px-4 py-4 text-ink-600">{{ $user->clinic?->nama_klinik ?? '-' }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <x-ui.button type="button" size="sm" variant="soft"
                                            wire:click="editUser({{ $user->id }})">Edit</x-ui.button>
                                        @if (auth()->id() !== $user->id)
                                            <x-ui.button type="button" size="sm" variant="danger"
                                                wire:click="deleteUser({{ $user->id }})">Hapus</x-ui.button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10">
                                    <x-ui.empty-state title="Belum ada pengguna."
                                        icon="solar:users-group-rounded-line-duotone" />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5 grid gap-3 lg:hidden">
                @forelse ($users as $user)
                    <div wire:key="user-card-{{ $user->id }}" class="rounded-2xl border border-ink-100 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm font-bold text-ink-900">{{ $user->name }}</div>
                                <div class="text-sm text-ink-500">{{ $user->email }}</div>
                            </div>
                            <x-ui.badge variant="neutral">{{ ucfirst($user->role) }}</x-ui.badge>
                        </div>
                        <div class="mt-2 text-sm text-ink-600">{{ $user->clinic?->nama_klinik ?? '-' }}</div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <x-ui.button type="button" size="sm" variant="soft"
                                wire:click="editUser({{ $user->id }})">Edit</x-ui.button>
                            @if (auth()->id() !== $user->id)
                                <x-ui.button type="button" size="sm" variant="danger"
                                    wire:click="deleteUser({{ $user->id }})">Hapus</x-ui.button>
                            @endif
                        </div>
                    </div>
                @empty
                    <x-ui.empty-state title="Belum ada pengguna." icon="solar:users-group-rounded-line-duotone" />
                @endforelse
            </div>

            <div class="mt-6">{{ $users->links() }}</div>
        </x-ui.card>
    </section>
</div>
