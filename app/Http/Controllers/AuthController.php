<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Menampilkan halaman form login
    public function showLoginForm()
    {
        // Pastikan teman Anda nanti membuat file view di resources/views/auth/login.blade.php
        return view('auth.login');
    }

    // 2. Memproses data dari form login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika berhasil, arahkan ke halaman utama (katalog wisata)
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // 3. Menampilkan halaman form register
    public function showRegisterForm()
    {
        // Pastikan teman Anda nanti membuat file view di resources/views/auth/register.blade.php
        return view('auth.register');
    }

    // 4. Memproses data dari form register
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'min:8', 'confirmed'], // Wajib ada field password_confirmation di form Blade
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Otomatis memberikan hak akses sebagai wisatawan
        $user->assignRole('wisatawan');

        // Langsung login-kan user setelah berhasil mendaftar
        Auth::login($user);

        return redirect('/');
    }

    // 5. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
