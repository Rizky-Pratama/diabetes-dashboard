<?php

namespace App\Livewire;

use App\Models\EducationContent;
use Livewire\Component;
use Livewire\WithPagination;

class EducationContentManager extends Component
{
    use WithPagination;

    public ?string $result_type = 'normal';

    public ?string $title = null;

    public ?string $content = null;

    public string $status = 'draft';

    public ?int $editingId = null;

    public int $perPage = 10;

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'result_type' => 'required|in:normal,prediabetes,diabetes',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ];
    }

    public function mount(): void
    {
        $this->authorizeAdmin();
    }

    public function createEducationContent(): void
    {
        $this->authorizeAdmin();
        $this->validate();

        EducationContent::create([
            'result_type' => $this->result_type,
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
        ]);

        $this->resetForm();
        session()->flash('status', 'Edukasi berhasil dibuat.');
    }

    public function editEducationContent(int $id): void
    {
        $this->authorizeAdmin();

        $educationContent = EducationContent::findOrFail($id);

        $this->editingId = $educationContent->id;
        $this->result_type = $educationContent->result_type;
        $this->title = $educationContent->title;
        $this->content = $educationContent->content;
        $this->status = $educationContent->status;
    }

    public function updateEducationContent(): void
    {
        $this->authorizeAdmin();
        $this->validate();

        $educationContent = EducationContent::findOrFail($this->editingId);
        $educationContent->update([
            'result_type' => $this->result_type,
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
        ]);

        $this->resetForm();
        session()->flash('status', 'Edukasi berhasil diperbarui.');
    }

    public function deleteEducationContent(int $id): void
    {
        $this->authorizeAdmin();

        EducationContent::findOrFail($id)->delete();
        session()->flash('status', 'Edukasi dihapus.');
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->result_type = 'normal';
        $this->title = null;
        $this->content = null;
        $this->status = 'draft';
    }

    public function render()
    {
        $educationContents = EducationContent::latest()->paginate($this->perPage);

        return view('livewire.education-content-manager', compact('educationContents'));
    }

    protected function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }
}
