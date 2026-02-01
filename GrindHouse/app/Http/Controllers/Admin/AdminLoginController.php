<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // 1. Show the dedicated admin login view
    public function showLoginForm()
    {
        return view('admin.auth.login'); 
    }

    // 2. Process the login attempt
    public function login(Request $request)
    {
        // Validate input (SECURITY)
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt Authentication
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            // Check Admin Status (Crucial Authorization step)
            if (Auth::user()->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard')); 
            }

            // Deny Access for non-admin users who tried to use /admin/login
            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied. You must be an authorized administrator.',
            ])->onlyInput('email');
        }

        // Authentication failed (wrong email/password)
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}