<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  

// // Registration routes
// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register.form');

// Route::post('/register', [AuthController::class, 'register'])->name('register');

// // Login routes
// Route::get('/login', function () {
//     return view('auth.login'); // GET for displaying the login form
// })->name('login.form'); // Name for the login form route

// Route::post('/login', [AuthController::class, 'login'])->name('login'); // POST for login

// // Email verification route
// Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);

// // Dashboard route
// Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// // Logout route
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// // Resend verification route
// Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('verification.resend');

// // Verification notice route
// Route::get('/verification-notice', function () {
//     return view('auth.verification-notice');
// })->name('verification.notice');

// // Password reset request routes
// Route::get('/password/reset', [AuthController::class, 'showResetRequestForm'])->name('password.request'); // Show the request form
// Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email'); // Handle form submission

// // Password reset routes
// Route::get('/password/reset/{token}/{email}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update'); // Handle password reset







// Guest routes
// Route::group(['middleware' => 'guest'], function () {
//     // Registration routes
//     Route::get('/register', function () {
//         return view('auth.register');
//     })->name('register.form');

//     Route::post('/register', [AuthController::class, 'register'])->name('register');

//     // Login routes
//     Route::get('/login', function () {
//         return view('auth.login'); // GET for displaying the login form
//     })->name('login.form');

//     Route::post('/login', [AuthController::class, 'login'])->name('login');

//     // Email verification route
//     Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);

//     // Password reset request routes
//     Route::get('/password/reset', [AuthController::class, 'showResetRequestForm'])->name('password.request');
//     Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
// });

// // Authenticated routes
// Route::group(['middleware' => 'auth.custom'], function () {
//     // Dashboard route
//     Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

//     // Logout route
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//     // Resend verification route
//     Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('verification.resend');

//     // Verification notice route
//     Route::get('/verification-notice', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');

//     // Password reset routes
//     Route::get('/password/reset/{token}/{email}', [AuthController::class, 'showResetForm'])->name('password.reset');
//     Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');
// });




use Illuminate\Support\Facades\Auth;  // Ensure you use this for middleware checks

// Guest routes (users who are not logged in)
Route::middleware('guest')->group(function () {
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
});

// Authenticated routes (users who are logged in)
Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Email verification route
    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
    
    // Resend verification route
    Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('verification.resend');
    
    // Verification notice route
    Route::get('/verification-notice', function () {
        return view('auth.verification-notice');
    })->name('verification.notice');
});

