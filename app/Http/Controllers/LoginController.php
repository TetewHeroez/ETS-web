<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba untuk login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Check if user is active
            if (Auth::user()->status === 'nonaktif') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => __('Akun Anda telah dinonaktifkan. Silakan hubungi administrator.'),
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        // Jika login gagal
        throw ValidationException::withMessages([
            'email' => __('Email atau password salah.'),
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Tampilkan dashboard setelah login
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}