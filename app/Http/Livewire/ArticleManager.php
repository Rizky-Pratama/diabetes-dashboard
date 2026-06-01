<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ArticleManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $title;

    public $content;

    public $status = 'draft';

    public $thumbnail;

    public $thumbnailFile = null;

    public $editingId = null;

    public $perPage = 10;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'status' => 'required|in:draft,published',
        'thumbnailFile' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        // default values
        $this->status = 'draft';
    }

    public function createArticle()
    {
        if (Gate::denies('create', Article::class)) {
            abort(403);
        }

        $this->validate();

        $user = Auth::user();

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . time(),
            'content' => $this->content,
            'thumbnail' => $this->storeThumbnail(),
            'status' => $this->status,
            'clinic_id' => $user && $user->role === 'petugas' ? $user->clinic_id : null,
        ];

        Article::create($data);

        $this->resetForm();
        session()->flash('status', 'Artikel berhasil dibuat.');
    }

    public function editArticle($id)
    {
        $article = Article::findOrFail($id);
        if (Gate::denies('view', $article)) {
            abort(403);
        }
        $this->editingId = $article->id;
        $this->title = $article->title;
        $this->content = $article->content;
        $this->status = $article->status;
        $this->thumbnail = $article->thumbnail;
        $this->thumbnailFile = null;
    }

    public function updateArticle()
    {
        $this->validate();

        $article = Article::findOrFail($this->editingId);
        if (Gate::denies('update', $article)) {
            abort(403);
        }
        $article->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . time(),
            'content' => $this->content,
            'thumbnail' => $this->storeThumbnail($article->thumbnail),
            'status' => $this->status,
        ]);

        $this->resetForm();
        session()->flash('status', 'Artikel berhasil diperbarui.');
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        if (Gate::denies('delete', $article)) {
            abort(403);
        }

        $article->delete();
        session()->flash('status', 'Artikel dihapus.');
    }

    protected function resetForm()
    {
        $this->editingId = null;
        $this->title = null;
        $this->content = null;
        $this->status = 'draft';
        $this->thumbnail = null;
        $this->thumbnailFile = null;
    }

    protected function storeThumbnail(?string $currentThumbnail = null): ?string
    {
        if (! $this->thumbnailFile instanceof TemporaryUploadedFile) {
            return $currentThumbnail ?? $this->thumbnail;
        }

        if ($currentThumbnail) {
            Storage::disk('public')->delete($currentThumbnail);
        }

        return $this->thumbnailFile->storePublicly('articles/thumbnails', 'public');
    }

    public function render()
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            $query = Article::latest();
        } elseif ($user && $user->role === 'petugas') {
            $query = Article::where('clinic_id', $user->clinic_id)->latest();
        } else {
            $query = Article::where('status', 'published')->latest();
        }

        $articles = $query->paginate($this->perPage);

        return view('livewire.article-manager', compact('articles'));
    }
}
