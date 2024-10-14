<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
    // Home route
    Route::get('/', function () {
        return view('layouts.app');
    })->name('home');

    // Registration routes
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register.form');

    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Login routes
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login.form');

    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Password reset request routes
    Route::get('/password/reset', [AuthController::class, 'showResetRequestForm'])->name('password.request');
    Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

    // Password reset routes
    Route::get('/password/reset/{token}/{email}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');
    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');


   
});

// Authenticated routes (users who are logged in)
Route::middleware('auth')->group(function () {
     // Email verification route

    // Verification notice route
    Route::get('/verification-notice', function () {
        return view('auth.verification-notice');
    })->name('verification.notice');
        // Resend verification route
        Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('verification.resend');
    // Dashboard route
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});


