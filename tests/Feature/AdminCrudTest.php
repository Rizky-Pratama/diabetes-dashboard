<?php

use App\Http\Livewire\ArticleManager;
use App\Http\Livewire\ClinicManager;
use App\Http\Livewire\UserManager;
use App\Models\Article;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('allows admin to manage clinics', function () {
  $admin = User::factory()->create(['role' => 'admin']);

  $this->actingAs($admin);
  Storage::fake('public');

  $this->get('/clinics')->assertSuccessful();

  $logo = UploadedFile::fake()->image('clinic-logo.png');

  Livewire::test(ClinicManager::class)
    ->set('nama_klinik', 'Klinik Sehat')
    ->set('logoFile', $logo)
    ->set('alamat', 'Jalan Mawar No. 1')
    ->set('telepon', '08123456789')
    ->set('email', 'klinik@example.com')
    ->call('createClinic');

  $clinic = Clinic::firstOrFail();
  $this->assertTrue(Storage::disk('public')->exists($clinic->logo));

  $this->assertDatabaseHas('clinics', [
    'nama_klinik' => 'Klinik Sehat',
    'email' => 'klinik@example.com',
  ]);
});

it('allows admin to manage users', function () {
  $admin = User::factory()->create(['role' => 'admin']);
  $clinic = Clinic::factory()->create();

  $this->actingAs($admin);

  $this->get('/users')->assertSuccessful();

  Livewire::test(UserManager::class)
    ->set('name', 'Petugas Klinik')
    ->set('email', 'petugas@example.com')
    ->set('password', 'password123')
    ->set('password_confirmation', 'password123')
    ->set('role', 'petugas')
    ->set('clinic_id', $clinic->id)
    ->call('createUser');

  $this->assertDatabaseHas('users', [
    'name' => 'Petugas Klinik',
    'email' => 'petugas@example.com',
    'role' => 'petugas',
    'clinic_id' => $clinic->id,
  ]);
});

it('allows admin to manage articles', function () {
  $admin = User::factory()->create(['role' => 'admin']);

  $this->actingAs($admin);
  Storage::fake('public');

  $this->get('/articles')->assertSuccessful();

  $thumbnail = UploadedFile::fake()->image('article-thumb.png');

  Livewire::test(ArticleManager::class)
    ->set('title', 'Tips Hidup Sehat')
    ->set('content', 'Konten edukasi singkat.')
    ->set('status', 'published')
    ->set('thumbnailFile', $thumbnail)
    ->call('createArticle');

  $article = Article::firstOrFail();
  $this->assertTrue(Storage::disk('public')->exists($article->thumbnail));

  $this->assertDatabaseHas('articles', [
    'title' => 'Tips Hidup Sehat',
    'status' => 'published',
  ]);
});

it('forbids non-admin users from opening management pages', function () {
  $user = User::factory()->create(['role' => 'pengguna']);

  $this->actingAs($user);

  $this->get('/clinics')->assertForbidden();
  $this->get('/users')->assertForbidden();
});
