<?php

use App\Http\Controllers\AuthController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $articles = Article::where('status', 'published')
        ->latest()
        ->limit(3)
        ->get();

    return view('welcome', compact('articles'));
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::get('/predict', function () {
        return view('pages.predict');
    })->name('prediction');

    Route::get('/articles', function () {
        return view('pages.articles');
    })->name('articles.index');

    Route::get('/clinics', function () {
        abort_unless(auth()->user()->role === 'admin', 403);

        return view('pages.clinics');
    })->name('clinics.index');

    Route::get('/users', function () {
        abort_unless(auth()->user()->role === 'admin', 403);

        return view('pages.users');
    })->name('users.index');

    Route::get('/education', function () {
        abort_unless(auth()->user()->role === 'admin', 403);

        return view('pages.education');
    })->name('education.index');
});

// Auth routes (simple controllers)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
