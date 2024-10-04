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



