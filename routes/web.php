<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\NewUserAuthController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
   Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
 Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Auth Routes
Route::prefix('admin')->group(function () {

    // Admin login/logout
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Admin dashboard & CRUD (protected)
    Route::middleware('auth:admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Users CRUD
        Route::get('/users/create', [AdminController::class, 'show'])->name('admin.create');
        Route::post('/users', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/users/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/users/{id}', [AdminController::class, 'delete'])->name('admin.destroy');
    });
});

// User Auth Routes
Route::get('/user/login', [NewUserAuthController::class, 'index'])->name('user.login');
Route::post('/user/login', [NewUserAuthController::class, 'login'])->name('user.login.post');

Route::get('send-mail',[mailController::class, 'sendEmail'] );

require __DIR__.'/auth.php';
