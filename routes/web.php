<?php

use App\Http\Controllers\Buyer\ProfileController;
use App\Http\Controllers\Buyer\Auth\RegisterController;
use App\Http\Controllers\Buyer\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Buyer routes
Route::prefix('buyer')->name('buyer.')->group(function () {

    // Guest only
    Route::middleware('guest')->group(function () {
        Route::get('/register', [RegisterController::class, 'create'])->name('register');
        Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
        Route::get('/login', [LoginController::class, 'create'])->name('login');
        Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    });

    // Protected
    Route::middleware(['auth', 'buyer'])->group(function () {
        Route::get('/dashboard', fn() => view('buyer.dashboard'))->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    });
});
