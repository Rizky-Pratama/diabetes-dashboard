<div class="grid gap-6 xl:grid-cols-5">
    <x-ui.card class="xl:col-span-2">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-bold text-ink-900">{{ $editingId ? 'Ubah Edukasi' : 'Edukasi Baru' }}</h3>
                <p class="mt-1 text-sm text-ink-500">Konten published akan tampil otomatis pada hasil prediksi.</p>
            </div>
            <x-icon name="solar:notebook-bookmark-line-duotone" class="text-brand-500" size="1.6rem" />
        </div>

        @if (session('status'))
            <div class="mt-4 rounded-2xl bg-health-50 px-4 py-3 text-sm font-semibold text-health-600">
                {{ session('status') }}
            </div>
        @endif

        <div class="mt-5 space-y-5">
            <x-form.select label="Tipe Hasil" name="result_type" model="result_type" required>
                <option value="normal">Normal</option>
                <option value="prediabetes">Prediabetes</option>
                <option value="diabetes">Diabetes</option>
            </x-form.select>

            <x-form.input label="Judul" name="title" model="title" placeholder="Contoh: Risiko Prediabetes"
                required />

            <x-form.rich-editor label="Konten" name="content" model="content" />

            <x-form.select label="Status" name="status" model="status" required>
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </x-form.select>

            <div class="flex flex-wrap gap-3 border-t border-ink-100 pt-5">
                @if ($editingId)
                    <x-ui.button type="button" wire:click="updateEducationContent">
                        <x-icon name="solar:diskette-line-duotone" size="1rem" />
                        Simpan Perubahan
                    </x-ui.button>
                    <x-ui.button type="button" variant="light" wire:click="resetForm">Batal</x-ui.button>
                @else
                    <x-ui.button type="button" wire:click="createEducationContent">
                        <x-icon name="solar:add-circle-line-duotone" size="1rem" />
                        Simpan Edukasi
                    </x-ui.button>
                @endif
            </div>
        </div>
    </x-ui.card>

    <x-ui.card class="xl:col-span-3">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-bold text-ink-900">Daftar Edukasi</h3>
                <p class="text-sm text-ink-500">Kelola pesan edukasi untuk setiap tipe hasil.</p>
            </div>
            <x-ui.badge variant="neutral">{{ $educationContents->total() }} data</x-ui.badge>
        </div>

        <div class="mt-5 hidden overflow-hidden rounded-2xl border border-ink-100 lg:block">
            <table class="min-w-full divide-y divide-ink-100 text-sm">
                <thead class="bg-ink-50 text-left text-ink-500">
                    <tr>
                        <th class="px-4 py-3 font-bold">Tipe</th>
                        <th class="px-4 py-3 font-bold">Judul</th>
                        <th class="px-4 py-3 font-bold">Status</th>
                        <th class="px-4 py-3 font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100 bg-white">
                    @forelse ($educationContents as $educationContent)
                        <tr wire:key="education-row-{{ $educationContent->id }}">
                            <td class="px-4 py-4">
                                <x-ui.badge :variant="match ($educationContent->result_type) {
                                    'diabetes' => 'danger',
                                    'prediabetes' => 'warning',
                                    default => 'success',
                                }">
                                    {{ $educationContent->result_type_label }}
                                </x-ui.badge>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-bold text-ink-900">{{ $educationContent->title }}</div>
                                <div class="text-xs text-ink-500">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($educationContent->content), 100) }}
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <x-ui.badge :variant="$educationContent->status === 'published' ? 'success' : 'neutral'">
                                    {{ ucfirst($educationContent->status) }}
                                </x-ui.badge>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <x-ui.button type="button" size="sm" variant="soft"
                                        wire:click="editEducationContent({{ $educationContent->id }})">
                                        Edit
                                    </x-ui.button>
                                    <x-ui.button type="button" size="sm" variant="danger"
                                        wire:click="deleteEducationContent({{ $educationContent->id }})">
                                        Hapus
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10">
                                <x-ui.empty-state title="Belum ada edukasi."
                                    icon="solar:notebook-bookmark-line-duotone" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5 grid gap-3 lg:hidden">
            @forelse ($educationContents as $educationContent)
                <div wire:key="education-card-{{ $educationContent->id }}"
                    class="rounded-2xl border border-ink-100 p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <x-ui.badge :variant="match ($educationContent->result_type) {
                                'diabetes' => 'danger',
                                'prediabetes' => 'warning',
                                default => 'success',
                            }">
                                {{ $educationContent->result_type_label }}
                            </x-ui.badge>
                            <div class="mt-3 text-sm font-bold text-ink-900">{{ $educationContent->title }}</div>
                            <p class="mt-2 text-sm leading-6 text-ink-500">
                                {{ \Illuminate\Support\Str::limit(strip_tags($educationContent->content), 120) }}</p>
                        </div>
                        <x-ui.badge :variant="$educationContent->status === 'published' ? 'success' : 'neutral'">
                            {{ ucfirst($educationContent->status) }}
                        </x-ui.badge>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <x-ui.button type="button" size="sm" variant="soft"
                            wire:click="editEducationContent({{ $educationContent->id }})">
                            Edit
                        </x-ui.button>
                        <x-ui.button type="button" size="sm" variant="danger"
                            wire:click="deleteEducationContent({{ $educationContent->id }})">
                            Hapus
                        </x-ui.button>
                    </div>
                </div>
            @empty
                <x-ui.empty-state title="Belum ada edukasi." icon="solar:notebook-bookmark-line-duotone" />
            @endforelse
        </div>

        <div class="mt-6">{{ $educationContents->links() }}</div>
    </x-ui.card>
</div>
