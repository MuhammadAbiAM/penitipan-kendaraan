<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string', // bisa username atau email
            'password' => 'required|string',
        ]);

        $login = $request->username;

        // Tentukan apakah input adalah email atau username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Siapkan kredensial untuk Auth::attempt
        $credentials = [
            $field => $login,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username/email atau password salah.'
        ])->withInput();
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|regex:/^[A-Za-z0-9]+$/',
            'email'    => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Cek apakah username sudah ada
        if (User::where('username', $request->username)->exists()) {
            return back()->withErrors([
                'username' => 'Username ini sudah digunakan. Silakan pilih username lain.'
            ])->withInput();
        }

        // Cek apakah email sudah ada
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors([
                'email' => 'Email ini sudah terdaftar. Gunakan email lain.'
            ])->withInput();
        }

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas', // HANYA PETUGAS!
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun petugas berhasil dibuat! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
