<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan Halaman Login
    public function login()
    {
        return view('pages.auth.login');
    }

    // Proses Autentikasi (Login)
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/wisata'); // Arahkan ke katalog wisata setelah login
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Tampilkan Halaman Registrasi
    public function register()
    {
        return view('pages.auth.register');
    }

    // Proses Simpan Data Registrasi
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string|max:20',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        // Buat user baru sesuai dengan kolom di tabel users[cite: 8]
        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'phone' => $request->no_hp,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Berikan role wisatawan (Spatie) agar terpisah dari admin[cite: 8]
        $user->assignRole('wisatawan');

        // Langsung login-kan setelah sukses mendaftar
        Auth::login($user);

        return redirect()->route('wisata.index');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
