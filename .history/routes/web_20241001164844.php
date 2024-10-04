<?php
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
// use Illuminate\Support\Facades\Auth;  


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
// Route::post('/logout', [AuthControllerclass, 'logout'])->name('logout');

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





use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
    // Home route
    Route::get('/', function () {
        return view('layout.app');
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

    // Email verification route
    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

    // Verification notice route
    Route::get('/verification-notice', function () {
        return view('auth.verification-notice');
    })->name('verification.notice');
});

// Authenticated routes (users who are logged in)
Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Resend verification route
    Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('verification.resend');
});

// Ensure proper logic in AuthController
// In your AuthController:

public function register(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'email_verification_token' => Str::random(60), // Create a token for email verification
    ]);

    // Send verification email (ensure you have a VerificationEmail mailable)
    Mail::to($user->email)->send(new VerificationEmail($user));

    // Redirect to the verification notice with a success message
    return redirect()->route('verification.notice')->with('status', 'Verification email sent! Please check your inbox.');
}

public function verifyEmail($token)
{
    // Find user by the verification token
    $user = User::where('email_verification_token', $token)->first();

    if (!$user) {
        return redirect()->route('login')->withErrors(['error' => 'Invalid verification token.']);
    }

    // Verify the user
    $user->email_verified_at = now();
    $user->email_verification_token = null; // Remove the token
    $user->save();

    // Log the user in
    Auth::login($user);

    return redirect()->route('dashboard')->with('status', 'Your email has been verified!');
}
