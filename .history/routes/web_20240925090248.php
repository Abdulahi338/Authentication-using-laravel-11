<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;  // Import the AuthController

Route::get('/register', function () {
    return view('auth.register');
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

