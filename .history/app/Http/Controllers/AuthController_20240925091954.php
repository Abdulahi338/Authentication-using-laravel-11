<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Registration function
    public function register(Request $request)
    {
        // Validate user input
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        
        // Hash password and create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Generate verification token and store in DB
        $token = Str::random(32);
        DB::table('email_verifications')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Send verification email
        Mail::to($user->email)->send(new VerificationMail($user, $token));

        return redirect('/login')->with('message', 'Registration successful! Please verify your email address.');
    }

    // Login function
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (auth()->attempt($credentials)) {
            // Authentication passed
            return redirect()->route('dashboard')->with('message', 'Login successful!');
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    

    // Email Verification function
    public function verifyEmail($token)
    {
        // Look for the token in the email_verifications table
        $verification = DB::table('email_verifications')->where('token', $token)->first();
        
        // If the token is not found, return an error
        if (!$verification) {
            return response()->json(['message' => 'Invalid verification token'], 400);
        }

        // Find the user by the token
        $user = User::find($verification->user_id);
        
        // Mark email as verified and save
        $user->email_verified_at = now();
        $user->save();

        // Optionally delete the token after successful verification
        DB::table('email_verifications')->where('token', $token)->delete();

        return redirect()->route('dashboard')->with('message', 'Email verified successfully!');
    }
    //Resend  Email
    public function resendVerification(Request $request)
{
    $user = auth()->user(); // Get the currently authenticated user

    // Check if the user already has a verified email
    if ($user->email_verified_at) {
        return response()->json(['message' => 'Email is already verified.'], 400);
    }

    // Generate a new verification token
    $token = Str::random(32);
    
    // Update or create a new verification record
    DB::table('email_verifications')->updateOrInsert(
        ['user_id' => $user->id],
        ['token' => $token, 'created_at' => now()]
    );

    // Send the verification email
    Mail::to($user->email)->send(new VerificationMail($user, $token));

    return response()->json(['message' => 'Verification email resent.']);
}

    // dashboard

    public function dashboard()
{
    // Assuming you have authentication set up
    if (auth()->check()) {
        return view('dashboard', ['user' => auth()->user()]);
    }

    return redirect('/login');  // Redirect to login if not authenticated
}

// logout 
public function logout(Request $request)
{
    auth()->logout();
    return redirect('/login')->with('message', 'You have been logged out successfully!');
}

}
