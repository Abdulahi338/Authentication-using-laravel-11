<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use Illuminate\Support\Facades\Auth;   

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
})->middleware();

// Password reset request routes
Route::get('/password/reset', [AuthController::class, 'showResetRequestForm'])->name('password.request'); // Show the request form
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email'); // Handle form submission

// Password reset routes
Route::get('/password/reset/{token}/{email}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update'); // Handle password reset





// Route::middleware('guest')->group(function () {
//     Route::get('/', function () {
//         return view('layout.app');
        
//     })->name('home');
//     // Registration routes
//     Route::get('/register', function () {
//         return view('auth.register');
//     })->name('register.form');
    
//     Route::post('/register', [AuthController::class, 'register'])->name('register');
    
//     // Login routes
//     Route::get('/login', function () {
//         return view('auth.login');
//     })->name('login.form');
    
//     Route::post('/login', [AuthController::class, 'login'])->name('login');
    
//     // Password reset request routes
//     Route::get('/password/reset', [AuthController::class, 'showResetRequestForm'])->name('password.request');
//     Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    
//     // Password reset routes
//     Route::get('/password/reset/{token}/{email}', [AuthController::class, 'showResetForm'])->name('password.reset');
//     Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');
// });

// // Authenticated routes (users who are logged in)
// Route::middleware('auth')->group(function () {
//     // Dashboard route
//     Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
//     // Logout route
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
//     // Email verification route
//     Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
    
//     // Resend verification route
//     Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('verification.resend');
    
//     // Verification notice route
//     Route::get('/verification-notice', function () {
//         return view('auth.verification-notice');
//     })->name('verification.notice');
// });

