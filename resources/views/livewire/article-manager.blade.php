<div class="space-y-6">
    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-slate-500">Modul Artikel Edukasi</p>
                <h2 class="mt-1 text-2xl font-semibold text-slate-900">Kelola artikel dengan tampilan sederhana</h2>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Artikel edukasi bersifat global dan dapat
                    dibaca semua role. Pengelolaan artikel hanya tersedia untuk admin.</p>
            </div>
            <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">{{ $articles->total() }}
                artikel</span>
        </div>

        @if (session('status'))
            <div class="mt-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('status') }}</div>
        @endif
    </section>

    <section class="grid gap-6 xl:grid-cols-5">
        @if ($canManageArticles)
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 xl:col-span-2">
                <h3 class="text-lg font-semibold text-slate-900">{{ $editingId ? 'Ubah Artikel' : 'Artikel Baru' }}</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
                        <input wire:model.live="title" type="text"
                            class="w-full rounded-2xl border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100"
                            placeholder="Masukkan judul artikel" />
                        @error('title')
                            <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                        @enderror
                    </div>
                    @push('scripts')
                        @vite('resources/js/pages/article.js')
                    @endpush
                    <div x-data="quillEditor(@entangle('content').live)">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Konten</label>

                        <div wire:ignore>
                            <div x-ref="editor" class="min-h-48 bg-white"></div>
                        </div>

                        @error('content')
                            <div class="mt-1 text-sm text-rose-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Thumbnail</label>
                        <input wire:model="thumbnailFile" type="file" accept="image/*"
                            class="w-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white focus:border-sky-400 focus:bg-white focus:ring-4 focus:ring-sky-100" />
                        @if ($thumbnailFile)
                            <img src="{{ $thumbnailFile->temporaryUrl() }}" alt="Pratinjau thumbnail"
                                class="mt-3 h-32 w-full rounded-2xl border border-slate-200 object-cover" />
                        @elseif ($thumbnail)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($thumbnail) }}"
                                alt="Thumbnail artikel"
                                class="mt-3 h-32 w-full rounded-2xl border border-slate-200 object-cover" />
                        @endif
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
                            <button type="button" wire:click="updateArticle"
                                class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan
                                Perubahan</button>
                            <button type="button" wire:click="resetForm"
                                class="rounded-full bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Batal</button>
                        @else
                            <button type="button" wire:click="createArticle"
                                class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Simpan
                                Artikel</button>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div
            class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70 {{ $canManageArticles ? 'xl:col-span-3' : 'xl:col-span-5' }}">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Artikel</h3>
                    <p class="text-sm text-slate-500">Gunakan card untuk mobile dan tabel sederhana untuk desktop.
                    </p>
                </div>
                <span
                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $articles->count() }}
                    tampil</span>
            </div>

            <div class="mt-5 hidden lg:block overflow-hidden rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Judul</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach ($articles as $article)
                            <tr wire:key="article-row-{{ $article->id }}">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($article->thumbnail)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->thumbnail) }}"
                                                alt="Thumbnail {{ $article->title }}"
                                                class="h-12 w-16 rounded-xl border border-slate-200 object-cover" />
                                        @else
                                            <div
                                                class="flex h-12 w-16 items-center justify-center rounded-xl bg-slate-100 text-xs font-semibold text-slate-500">
                                                NO IMG</div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-slate-900">{{ $article->title }}</div>
                                            <div class="text-xs text-slate-500">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 90) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $article->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($article->status) }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        @can('update', $article)
                                            <button type="button" wire:click="editArticle({{ $article->id }})"
                                                class="rounded-full bg-sky-100 px-4 py-2 text-xs font-semibold text-sky-700 transition hover:bg-sky-200">Edit</button>
                                        @endcan
                                        @can('delete', $article)
                                            <button type="button" wire:click="deleteArticle({{ $article->id }})"
                                                class="rounded-full bg-rose-100 px-4 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-200">Hapus</button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5 grid gap-3 lg:hidden">
                @foreach ($articles as $article)
                    <div wire:key="article-card-{{ $article->id }}" class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-start gap-3">
                            @if ($article->thumbnail)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->thumbnail) }}"
                                    alt="Thumbnail {{ $article->title }}"
                                    class="h-16 w-20 rounded-2xl border border-slate-200 object-cover" />
                            @else
                                <div
                                    class="flex h-16 w-20 items-center justify-center rounded-2xl bg-slate-100 text-[10px] font-semibold text-slate-500">
                                    NO IMG</div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-semibold text-slate-900">{{ $article->title }}</div>
                                <p class="mt-1 text-sm text-slate-500">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120) }}</p>
                            </div>
                            <span
                                class="rounded-full px-3 py-1 text-xs font-semibold {{ $article->status === 'published' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ ucfirst($article->status) }}</span>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                            @can('update', $article)
                                <button type="button" wire:click="editArticle({{ $article->id }})"
                                    class="rounded-full bg-sky-100 px-4 py-2 text-xs font-semibold text-sky-700">Edit</button>
                            @endcan
                            @can('delete', $article)
                                <button type="button" wire:click="deleteArticle({{ $article->id }})"
                                    class="rounded-full bg-rose-100 px-4 py-2 text-xs font-semibold text-rose-700">Hapus</button>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $articles->links() }}</div>
        </div>
    </section>
</div>
