<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login authentication request
    public function login(Request $request)
    {
        // Validate input credentials with server-side validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8',              // at least 8 letter
                'regex:/[a-z]/',      // Lowercase letter
                'regex:/[A-Z]/',      // Uppercase letter
                'regex:/[0-9]/',      // Numbers
                'regex:/[@$!%*#?&]/', // Special characters
            ],
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect to dashboard or intended page on success
            return redirect()->intended('/customers')->with('success', 'Logged in successfully.');
        }

        // Authentication failed - return back with error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
