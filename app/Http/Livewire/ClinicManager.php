<?php

namespace App\Http\Livewire;

use App\Models\Clinic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ClinicManager extends Component
{
  use WithFileUploads;
  use WithPagination;

  public string $nama_klinik = '';

  public ?string $logo = null;

  public mixed $logoFile = null;

  public string $alamat = '';

  public string $telepon = '';

  public string $email = '';

  public ?int $editingId = null;

  public int $perPage = 10;

  protected array $rules = [
    'nama_klinik' => 'required|string|max:255',
    'logoFile' => 'nullable|image|max:2048',
    'alamat' => 'required|string',
    'telepon' => 'required|string|max:50',
    'email' => 'required|email|max:255',
  ];

  protected function ensureAdmin(): void
  {
    abort_unless(Auth::user()?->role === 'admin', 403);
  }

  public function createClinic(): void
  {
    $this->ensureAdmin();
    $this->validate();

    Clinic::create($this->validatedData());

    $this->resetForm();
    session()->flash('status', 'Data klinik berhasil ditambahkan.');
  }

  public function editClinic(int $clinicId): void
  {
    $this->ensureAdmin();

    $clinic = Clinic::findOrFail($clinicId);

    $this->editingId = $clinic->id;
    $this->nama_klinik = $clinic->nama_klinik;
    $this->logo = $clinic->logo;
    $this->logoFile = null;
    $this->alamat = $clinic->alamat;
    $this->telepon = $clinic->telepon;
    $this->email = $clinic->email;
  }

  public function updateClinic(): void
  {
    $this->ensureAdmin();
    $this->validate();

    Clinic::findOrFail($this->editingId)->update($this->validatedData());

    $this->resetForm();
    session()->flash('status', 'Data klinik berhasil diperbarui.');
  }

  public function deleteClinic(int $clinicId): void
  {
    $this->ensureAdmin();

    Clinic::findOrFail($clinicId)->delete();

    if ($this->editingId === $clinicId) {
      $this->resetForm();
    }

    session()->flash('status', 'Data klinik berhasil dihapus.');
  }

  public function resetForm(): void
  {
    $this->reset(['editingId', 'nama_klinik', 'logo', 'logoFile', 'alamat', 'telepon', 'email']);
  }

  protected function validatedData(): array
  {
    $logoPath = $this->logo;

    if ($this->logoFile instanceof TemporaryUploadedFile) {
      if ($logoPath) {
        Storage::disk('public')->delete($logoPath);
      }

      $logoPath = $this->logoFile->storePublicly('clinics/logos', 'public');
    }

    return [
      'nama_klinik' => $this->nama_klinik,
      'logo' => $logoPath,
      'alamat' => $this->alamat,
      'telepon' => $this->telepon,
      'email' => $this->email,
    ];
  }

  public function render()
  {
    $this->ensureAdmin();

    return view('livewire.clinic-manager', [
      'clinics' => Clinic::latest()->paginate($this->perPage),
    ]);
  }
}
