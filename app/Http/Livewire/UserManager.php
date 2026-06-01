<?php

namespace App\Http\Livewire;

use App\Models\Clinic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
  use WithPagination;

  public string $name = '';

  public string $email = '';

  public string $password = '';

  public string $password_confirmation = '';

  public string $role = 'pengguna';

  public ?int $clinic_id = null;

  public ?int $editingId = null;

  public int $perPage = 10;

  protected function ensureAdmin(): void
  {
    abort_unless(Auth::user()?->role === 'admin', 403);
  }

  protected function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->editingId)],
      'password' => [$this->editingId ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
      'role' => ['required', Rule::in(['admin', 'petugas', 'pengguna'])],
      'clinic_id' => ['nullable', 'integer', Rule::exists('clinics', 'id')],
    ];
  }

  public function createUser(): void
  {
    $this->ensureAdmin();
    $this->validate();

    User::create([
      'name' => $this->name,
      'email' => $this->email,
      'password' => Hash::make($this->password),
      'role' => $this->role,
      'clinic_id' => $this->role === 'petugas' ? $this->clinic_id : null,
    ]);

    $this->resetForm();
    session()->flash('status', 'Pengguna berhasil ditambahkan.');
  }

  public function editUser(int $userId): void
  {
    $this->ensureAdmin();

    $user = User::findOrFail($userId);

    $this->editingId = $user->id;
    $this->name = $user->name;
    $this->email = $user->email;
    $this->role = $user->role;
    $this->clinic_id = $user->clinic_id;
    $this->password = '';
    $this->password_confirmation = '';
  }

  public function updateUser(): void
  {
    $this->ensureAdmin();
    $this->validate();

    $user = User::findOrFail($this->editingId);

    $data = [
      'name' => $this->name,
      'email' => $this->email,
      'role' => $this->role,
      'clinic_id' => $this->role === 'petugas' ? $this->clinic_id : null,
    ];

    if ($this->password !== '') {
      $data['password'] = Hash::make($this->password);
    }

    $user->update($data);

    $this->resetForm();
    session()->flash('status', 'Pengguna berhasil diperbarui.');
  }

  public function deleteUser(int $userId): void
  {
    $this->ensureAdmin();

    abort_if(Auth::id() === $userId, 422, 'Tidak dapat menghapus akun sendiri.');

    User::findOrFail($userId)->delete();

    if ($this->editingId === $userId) {
      $this->resetForm();
    }

    session()->flash('status', 'Pengguna berhasil dihapus.');
  }

  public function resetForm(): void
  {
    $this->reset(['editingId', 'name', 'email', 'password', 'password_confirmation', 'role', 'clinic_id']);
    $this->role = 'pengguna';
  }

  public function render()
  {
    $this->ensureAdmin();

    return view('livewire.user-manager', [
      'users' => User::with('clinic')->latest()->paginate($this->perPage),
      'clinics' => Clinic::orderBy('nama_klinik')->get(),
    ]);
  }
}
