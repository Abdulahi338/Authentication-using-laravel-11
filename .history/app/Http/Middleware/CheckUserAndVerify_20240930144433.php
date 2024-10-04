<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckUserAndVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->withErrors(['message' => 'You must be logged in to access this page.']);
        }

        // Handle email verification route
        if ($request->is('verify-email/*')) {
            $token = $request->route('token');
            $verification = DB::table('email_verifications')->where('token', $token)->first();
            
            // If the token is not found, return an error
            if (!$verification) {
                return redirect('/login')->withErrors(['message' => 'Invalid verification token.']);
            }

            // Optional: You could check if the user already exists
            $user = User::find($verification->user_id);
            if (!$user) {
                return redirect('/login')->withErrors(['message' => 'User not found.']);
            }
        }

        return $next($request);
        protected $routeMiddleware = [
            // Other middleware...
            'check.user.verify' => \App\Http\Middleware\CheckUserAndVerify::class,
        ];
        
    }
}
