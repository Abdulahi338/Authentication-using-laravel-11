<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
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
    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


});


use App\Http\Controllers\PostController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


        // Email Routes
        Route::get('/dashboard', [EmailController::class, 'dashboard'])->name('dashboard');

        Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');
        Route::get('/emails/create', [EmailController::class, 'create'])->name('emails.create');
        Route::get('/emails/outgoing', [EmailController::class, 'outgoingEmails'])->name('emails.outgoing');
        Route::get('/emails/{email}', [EmailController::class, 'view'])->name('emails.view');
        Route::delete('/emails/{email}', [EmailController::class, 'destroy'])->name('emails.destroy');


        Route::post('/emails', [EmailController::class, 'store'])->name('emails.store');
        Route::get('/emails/incoming', [EmailController::class, 'incomingEmails'])->name('emails.incoming');
        Route::delete('/emails/outgoing', [EmailController::class, 'deleteOutgoing'])->name('emails.outgoing.delete');

});


