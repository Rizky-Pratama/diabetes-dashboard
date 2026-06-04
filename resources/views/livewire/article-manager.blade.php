<div class="space-y-6">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-ink-900">Daftar Artikel</h2>
            <p class="text-sm text-ink-500">Artikel edukasi global yang dapat dibaca semua role.</p>
        </div>
        <x-ui.badge variant="primary">{{ $articles->total() }} artikel</x-ui.badge>
    </div>

    @if (session('status'))
        <div class="rounded-2xl bg-health-50 px-4 py-3 text-sm font-semibold text-health-600">
            {{ session('status') }}
        </div>
    @endif

    <section class="grid gap-6 xl:grid-cols-5">
        @if ($canManageArticles)
            <x-ui.card class="xl:col-span-2">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-ink-900">{{ $editingId ? 'Ubah Artikel' : 'Artikel Baru' }}
                        </h3>
                        <p class="mt-1 text-sm text-ink-500">Gunakan editor untuk menulis edukasi yang nyaman dibaca.
                        </p>
                    </div>
                    <x-icon name="solar:document-add-line-duotone" class="text-brand-500" size="1.6rem" />
                </div>

                <div class="mt-5 space-y-5">
                    <x-form.input label="Judul" name="title" model="title" placeholder="Masukkan judul artikel"
                        required />

                    <x-form.rich-editor label="Konten" name="content" model="content" />

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-ink-700">Thumbnail</label>
                        <input wire:model="thumbnailFile" type="file" accept="image/*"
                            class="w-full rounded-2xl border border-dashed border-ink-200 bg-white px-4 py-3 text-sm text-ink-600 outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-ink-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white focus:border-brand-400 focus:ring-4 focus:ring-brand-100" />
                        @if ($thumbnailFile)
                            <img src="{{ $thumbnailFile->temporaryUrl() }}" alt="Pratinjau thumbnail"
                                class="mt-3 h-36 w-full rounded-2xl border border-ink-100 object-cover" />
                        @elseif ($thumbnail)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($thumbnail) }}"
                                alt="Thumbnail artikel"
                                class="mt-3 h-36 w-full rounded-2xl border border-ink-100 object-cover" />
                        @endif
                    </div>

                    <x-form.select label="Status" name="status" model="status" required>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </x-form.select>

                    <div class="flex flex-wrap gap-3 border-t border-ink-100 pt-5">
                        @if ($editingId)
                            <x-ui.button type="button" wire:click="updateArticle">
                                <x-icon name="solar:diskette-line-duotone" size="1rem" />
                                Simpan Perubahan
                            </x-ui.button>
                            <x-ui.button type="button" variant="light" wire:click="resetForm">Batal</x-ui.button>
                        @else
                            <x-ui.button type="button" wire:click="createArticle">
                                <x-icon name="solar:add-circle-line-duotone" size="1rem" />
                                Simpan Artikel
                            </x-ui.button>
                        @endif
                    </div>
                </div>
            </x-ui.card>
        @endif

        <x-ui.card class="{{ $canManageArticles ? 'xl:col-span-3' : 'xl:col-span-5' }}">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-bold text-ink-900">Artikel Tersedia</h3>
                    <p class="text-sm text-ink-500">Tampilan tabel untuk desktop dan kartu untuk mobile.</p>
                </div>
                <x-ui.badge variant="neutral">{{ $articles->count() }} tampil</x-ui.badge>
            </div>

            <div class="mt-5 hidden overflow-hidden rounded-2xl border border-ink-100 lg:block">
                <table class="min-w-full divide-y divide-ink-100 text-sm">
                    <thead class="bg-ink-50 text-left text-ink-500">
                        <tr>
                            <th class="px-4 py-3 font-bold">Judul</th>
                            <th class="px-4 py-3 font-bold">Status</th>
                            <th class="px-4 py-3 font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-100 bg-white">
                        @forelse ($articles as $article)
                            <tr wire:key="article-row-{{ $article->id }}">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($article->thumbnail)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->thumbnail) }}"
                                                alt="Thumbnail {{ $article->title }}"
                                                class="h-12 w-16 rounded-2xl border border-ink-100 object-cover" />
                                        @else
                                            <div
                                                class="flex h-12 w-16 items-center justify-center rounded-2xl bg-brand-50 text-brand-500">
                                                <x-icon name="solar:document-text-line-duotone" size="1.3rem" />
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-ink-900">
                                                <a href="{{ route('articles.show', $article) }}" wire:navigate
                                                    class="transition hover:text-brand-700">
                                                    {{ $article->title }}
                                            </div>
                                            <div class="text-xs text-ink-500">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 90) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <x-ui.badge :variant="$article->status === 'published' ? 'success' : 'neutral'">
                                        {{ ucfirst($article->status) }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        @can('update', $article)
                                            <x-ui.button type="button" size="sm" variant="soft"
                                                wire:click="editArticle({{ $article->id }})">
                                                <x-icon name="solar:pen-2-bold-duotone" size="1rem" />
                                            </x-ui.button>
                                        @endcan
                                        @can('delete', $article)
                                            <x-ui.button type="button" size="sm" variant="danger"
                                                wire:click="deleteArticle({{ $article->id }})">
                                                <x-icon name="solar:trash-bin-trash-bold-duotone" size="1rem" />
                                            </x-ui.button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-10">
                                    <x-ui.empty-state title="Belum ada artikel."
                                        icon="solar:document-text-line-duotone" />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5 grid gap-3 lg:hidden">
                @forelse ($articles as $article)
                    <div wire:key="article-card-{{ $article->id }}" class="rounded-2xl border border-ink-100 p-4">
                        <div class="flex items-start gap-3">
                            @if ($article->thumbnail)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->thumbnail) }}"
                                    alt="Thumbnail {{ $article->title }}"
                                    class="h-16 w-20 rounded-2xl border border-ink-100 object-cover" />
                            @else
                                <div
                                    class="flex h-16 w-20 items-center justify-center rounded-2xl bg-brand-50 text-brand-500">
                                    <x-icon name="solar:document-text-line-duotone" size="1.5rem" />
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold text-ink-900">{{ $article->title }}</div>
                                <p class="mt-1 text-sm leading-6 text-ink-500">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}</p>
                            </div>
                            <x-ui.badge :variant="$article->status === 'published' ? 'success' : 'neutral'">
                                {{ ucfirst($article->status) }}
                            </x-ui.badge>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @can('update', $article)
                                <x-ui.button type="button" size="sm" variant="soft"
                                    wire:click="editArticle({{ $article->id }})">
                                    Edit
                                </x-ui.button>
                            @endcan
                            @can('delete', $article)
                                <x-ui.button type="button" size="sm" variant="danger"
                                    wire:click="deleteArticle({{ $article->id }})">
                                    Hapus
                                </x-ui.button>
                            @endcan
                        </div>
                    </div>
                @empty
                    <x-ui.empty-state title="Belum ada artikel." icon="solar:document-text-line-duotone" />
                @endforelse
            </div>

            <div class="mt-6">{{ $articles->links() }}</div>
        </x-ui.card>
    </section>
</div>
