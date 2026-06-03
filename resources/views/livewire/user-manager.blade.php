<div class="space-y-6">
    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Modul Pengguna</p>
                <h1 class="mt-1 text-2xl font-semibold text-slate-900">Kelola pengguna dan role</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Admin dapat menambah petugas klinik, mengatur
                    role, dan menghubungkan pengguna dengan klinik.</p>
            </div>
            <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">{{ $users->total() }}
                pengguna</span>
        </div>

        @if (session('status'))
            <div class="mt-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('status') }}</div>
        @endif
    </section>

    <section class="grid gap-6 xl:grid-cols-5">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 xl:col-span-2">
            <h2 class="text-lg font-semibold text-slate-900">{{ $editingId ? 'Ubah Pengguna' : 'Pengguna Baru' }}</h2>
            <div class="mt-4 space-y-4">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Nama</label>
                    <input wire:model.live="name" type="text"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Nama pengguna" />
                    @error('name')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input wire:model.live="email" type="email"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="email@domain.com" />
                    @error('email')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Password
                        {{ $editingId ? '(opsional)' : '' }}</label>
                    <input wire:model.live="password" type="password"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Password" />
                    @error('password')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                    <input wire:model.live="password_confirmation" type="password"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                        placeholder="Konfirmasi password" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Role</label>
                    <select wire:model.live="role"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100">
                        <option value="pengguna">Pengguna</option>
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div wire:show="role === 'petugas'">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Klinik</label>
                    <select wire:model.live="clinic_id"
                        class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100">
                        <option value="">- Tidak terhubung -</option>
                        @foreach ($clinics as $clinic)
                            <option value="{{ $clinic->id }}">{{ $clinic->nama_klinik }}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-slate-500">Klinik wajib dipilih untuk role petugas.</p>
                    @error('clinic_id')
                        <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    @if ($editingId)
                        <button type="button" wire:click="updateUser"
                            class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan
                            Perubahan</button>
                        <button type="button" wire:click="resetForm"
                            class="rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Batal</button>
                    @else
                        <button type="button" wire:click="createUser"
                            class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan
                            Pengguna</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 xl:col-span-3">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">Daftar Pengguna</h2>
                    <p class="text-sm text-slate-500">Role dan klinik ditampilkan agar mudah dicek.</p>
                </div>
                <span
                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $users->count() }}
                    tampil</span>
            </div>

            <div class="mt-5 hidden lg:block overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Nama</th>
                            <th class="px-4 py-3 font-semibold">Role</th>
                            <th class="px-4 py-3 font-semibold">Klinik</th>
                            <th class="px-4 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach ($users as $user)
                            <tr wire:key="user-row-{{ $user->id }}">
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-slate-900">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-4 py-4"><span
                                        class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="px-4 py-4 text-slate-600">{{ $user->clinic?->nama_klinik ?? '-' }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" wire:click="editUser({{ $user->id }})"
                                            class="rounded-full bg-sky-100 px-4 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-200">Edit</button>
                                        @if (auth()->id() !== $user->id)
                                            <button type="button" wire:click="deleteUser({{ $user->id }})"
                                                class="rounded-full bg-rose-100 px-4 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Hapus</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5 grid gap-3 lg:hidden">
                @foreach ($users as $user)
                    <div wire:key="user-card-{{ $user->id }}" class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm font-semibold text-slate-900">{{ $user->name }}</div>
                                <div class="text-sm text-slate-500">{{ $user->email }}</div>
                            </div>
                            <span
                                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($user->role) }}</span>
                        </div>
                        <div class="mt-2 text-sm text-slate-600">{{ $user->clinic?->nama_klinik ?? '-' }}</div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <button type="button" wire:click="editUser({{ $user->id }})"
                                class="rounded-full bg-sky-100 px-4 py-2 text-xs font-semibold text-sky-700">Edit</button>
                            @if (auth()->id() !== $user->id)
                                <button type="button" wire:click="deleteUser({{ $user->id }})"
                                    class="rounded-full bg-rose-100 px-4 py-2 text-xs font-semibold text-rose-700">Hapus</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $users->links() }}</div>
        </div>
    </section>
</div>
