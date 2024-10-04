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
            'name' =>'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        
        // Hash password and create user
        $user = User::create([
            ''
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

        // Return success response
        return response()->json(['message' => 'Registered! Please verify your email.']);
    }

    // Login function
    public function login(Request $request)
    {
        // Get user credentials from the request
        $credentials = $request->only('email', 'password');
        
        // Find user by email
        $user = User::where('email', $credentials['email'])->first();
        
        // Check if the user exists and if the password is correct
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Check if the user has verified their email
        if (!$user->email_verified_at) {
            return response()->json(['message' => 'Please verify your email first'], 403);
        }

        // If everything is valid, create session or authentication token
        // (You can implement a token-based system here if you're using an API)

        return response()->json(['message' => 'Login successful']);
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

        return response()->json(['message' => 'Email verified successfully!']);
    }
}
