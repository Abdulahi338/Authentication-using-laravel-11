<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  // Import the AuthController

Route::get('/register', function () {
    return view('auth.register');
});


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']); // POST for login
Route::get('/login', function () {
    return view('auth.login'); // GET for displaying the login form
});

Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('verification.resend');


Route::get('/verification-notice', function () {
    return view('auth.verification-notice');
})->name('verification.notice');

// // Show the password reset form
// Route::get('/password/reset/{token}', function ($token) {
//     return view('auth.passwords.reset', ['token' => $token]);
// })->name('password.reset');

// // Handle the password reset request
// Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');

// Show the password reset request form
Route::get('/password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');

// Handle the password reset email request
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');


