<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  // Import the AuthController

// Registration routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');

Route::post('/register', [AuthController::class, 'register'])->name('register');

// Login routes
Route::get('/login', function () {
    return view('auth.login'); // GET for displaying the login form
})->name('login.form'); // Name for the login form route

Route::post('/login', [AuthController::class, 'login'])->name('login'); // POST for login

// Email verification route
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);

// Dashboard route
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Resend verification route
Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('verification.resend');

// Verification notice route
Route::get('/verification-notice', function () {
    return view('auth.verification-notice');
})->name('verification.notice');

// Password reset request routes
Route::get('/password/reset', [AuthController::class, 'showResetRequestForm'])->name('password.request'); // Show the request form
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email'); // Handle form submission

// Password reset routes
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset'); // Show reset form with token
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update'); // Handle password reset