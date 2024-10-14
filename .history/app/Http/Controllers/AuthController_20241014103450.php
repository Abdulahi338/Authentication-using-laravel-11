<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Registration function
    public function register(Request $request)
    {
        // Validate user input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3|confirmed', // Updated min length for security
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

        return redirect()->route('auth.'); // Ensure you have a route for this
    }

    // Login function
    public function login(Request $request)
    {
        // Validate the login request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Attempt to find the user
        $user = User::where('email', $credentials['email'])->first();
    
        // Check if the user exists
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }
    
        // Check if the email is verified
        if (!$user->email_verified_at) {
            return redirect()->back()->withErrors(['email' => 'Please verify your email first.'])->withInput();
        }
    
        // Check the password
        if (!Hash::check($credentials['password'], $user->password)) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }
    
        // Log the user in
        auth()->login($user);
    
        return redirect()->route('dashboard'); // Redirect to the dashboard after successful login
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
    
        // Log the user in
        auth()->login($user);
    
        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('message', 'Email verified successfully! Welcome to your dashboard.');
    }
    

    // Resend Email Verification
    public function resendVerification(Request $request)
    {
        // Validate the request to ensure an email is provided
        $request->validate([
            'email' => 'required|email',
        ]);
    
        // Find the user by email
        $user = User::where('email', $request->email)->first();
    
        // Check if the user exists
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found.']);
        }
    
        // Check if the user already has a verified email
        if ($user->email_verified_at) {
            return redirect()->back()->withErrors(['email' => 'Email is already verified.']);
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
    
        return redirect()->back()->with('message', 'Verification email resent.');
    }
    

    // Show password reset request form
    public function showResetRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Handle sending the reset link
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);
    
        // Send the reset link
        $status = Password::sendResetLink($request->only('email'));

        // Return response based on the status
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Password Reset Form
    public function showResetForm($token, $email)
    {
        // Verify the email and token before showing the reset form
        return view('auth.passwords.reset')->with(['token' => $token, 'email' => $email]);
    }

    // Handle password reset
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:3|confirmed', 
            'token' => 'required',
        ]);

        // Reset the password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Dashboard
    public function dashboard()
    {
        // Assuming you have authentication set up
        if (auth()->check()) {
            return view('dashboard', ['user' => auth()->user()]);
        }

        return redirect('/login');  // Redirect to login if not authenticated
    }

    // Logout
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/login')->with('message', 'You have been logged out successfully!');
    }
}
