<?php

use App\Models\PredictionHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires admin role for users report', function () {
    $user = User::factory()->create(['role' => 'pengguna']);

    $this->actingAs($user)
        ->get(route('report.users'))
        ->assertForbidden();
});

it('returns users report pdf for admin', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
        ->get(route('report.users'));

    $response->assertSuccessful();
    expect($response->headers->get('Content-Type'))->toBe('application/pdf');
});

it('returns clinics report pdf for admin', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
        ->get(route('report.clinics'));

    $response->assertSuccessful();
    expect($response->headers->get('Content-Type'))->toBe('application/pdf');
});

it('returns prediction summary report pdf for admin', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
        ->get(route('report.prediction.summary'));

    $response->assertSuccessful();
    expect($response->headers->get('Content-Type'))->toBe('application/pdf');
});

it('returns prediction history report pdf for user', function () {
    $user = User::factory()->create(['role' => 'pengguna']);

    $response = $this->actingAs($user)
        ->get(route('report.prediction.history'));

    $response->assertSuccessful();
    expect($response->headers->get('Content-Type'))->toBe('application/pdf');
});

it('returns prediction single report pdf for user', function () {
    $user = User::factory()->create(['role' => 'pengguna']);
    $prediction = PredictionHistory::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)
        ->get(route('report.prediction.single', $prediction));

    $response->assertSuccessful();
    expect($response->headers->get('Content-Type'))->toBe('application/pdf');
});

it('forbids user from accessing other user prediction single report', function () {
    $user = User::factory()->create(['role' => 'pengguna']);
    $otherUser = User::factory()->create(['role' => 'pengguna']);
    $prediction = PredictionHistory::factory()->create(['user_id' => $otherUser->id]);

    $this->actingAs($user)
        ->get(route('report.prediction.single', $prediction))
        ->assertForbidden();
});
