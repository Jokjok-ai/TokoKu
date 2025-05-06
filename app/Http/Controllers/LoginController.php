<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    protected function rememberDuration()
{
    return 24 * 60; // 1 days in minutes
}
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        // Attempt to authenticate user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard')
                ->with('success', 'Login berhasil!');
        }
        

        // If authentication fails
        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    public function showRegisterForm()
{
    return view('auth.register');
}

// app/Http/Controllers/LoginController.php

public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'nullable|string|unique:users,username',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => User::ROLE_ADMIN, // Default role admin
    ]);

    // Auth::login($user);

    return redirect('/login')->with('success', 'Registrasi berhasil!');
}

public function showForgotPasswordForm()
{
    return view('auth.forgot_password');
}

public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $status = \Password::sendResetLink(
        $request->only('email')
    );

    return $status === \Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
}


    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')
            ->with('success', 'Anda telah logout.');
    }
}
