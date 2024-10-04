<?php 
public function register(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);
    
    // Hash password
    $user = User::create([
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    // Generate verification token and email
    $token = Str::random(32);
    DB::table('email_verifications')->insert([
        'user_id' => $user->id,
        'token' => $token,
        'created_at' => now(),
    ]);

    Mail::to($user->email)->send(new VerificationMail($user, $token));

    return response()->json(['message' => 'Registered! Please verify your email.']);
}

// locale

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    
    $user = User::where('email', $credentials['email'])->first();
    
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    if (!$user->email_verified_at) {
        return response()->json(['message' => 'Please verify your email first'], 403);
    }

    // Start session or create auth token...
}


// Email Verification
public function verifyEmail($token)
{
    $verification = DB::table('email_verifications')->where('token', $token)->first();
    
    if (!$verification) {
        return response()->json(['message' => 'Invalid verification token'], 400);
    }

    $user = User::find($verification->user_id);
    $user->email_verified_at = now();
    $user->save();

    // Optionally delete the verification record after success
    DB::table('email_verifications')->where('token', $token)->delete();

    return response()->json(['message' => 'Email verified successfully!']);
}
