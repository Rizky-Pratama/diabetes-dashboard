<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
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
        if (auth()->user()->role === 'admin') {
            return view('pages.articles');
        }

        $articles = Article::where('status', 'published')
            ->latest()
            ->paginate(9);

        return view('pages.article-list', compact('articles'));
    })->name('articles.index');

    Route::get('/articles/{article:slug}', function (Article $article) {
        abort_unless(auth()->user()->can('view', $article), 403);

        $relatedArticles = Article::where('status', 'published')
            ->whereKeyNot($article->getKey())
            ->latest()
            ->limit(3)
            ->get();

        return view('pages.article-show', compact('article', 'relatedArticles'));
    })->name('articles.show');

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

    // ─── Reports ───
    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/prediction/{prediction}', [ReportController::class, 'predictionSingle'])->name('prediction.single');
        Route::get('/prediction-history', [ReportController::class, 'predictionHistory'])->name('prediction.history');
        Route::get('/prediction-summary', [ReportController::class, 'predictionSummary'])->name('prediction.summary');
        Route::get('/users', [ReportController::class, 'users'])->name('users');
        Route::get('/clinics', [ReportController::class, 'clinics'])->name('clinics');
    });
});

// Auth routes (simple controllers)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
