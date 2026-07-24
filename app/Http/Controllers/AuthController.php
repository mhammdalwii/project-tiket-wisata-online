<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <-- Tambahan untuk fitur upload foto

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('wisata.index');
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string|max:20',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'phone' => $request->no_hp,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('wisatawan');
        Auth::login($user);

        return redirect()->route('wisata.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // ==========================================
    // FITUR PROFIL (Dipindahkan dari kode Frontend)
    // ==========================================

    public function profil()
    {
        // Langsung tampilkan view profil, data user diambil langsung di Blade via Auth::user()
        return view('pages.wisata.profil');
    }

    public function updateProfil(Request $request)
    {
        // PERBAIKAN: Ambil data user langsung dari Model Eloquent
        // agar fitur save() bisa terbaca dengan sempurna
        $user = User::find(Auth::id());

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp'        => 'required|string|max:20',
            'avatar'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password'     => 'nullable|string|min:6',
        ]);

        $user->name = $request->nama_lengkap;
        $user->phone = $request->no_hp;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            // Simpan foto baru ke folder public/storage/avatars
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Sekarang method save() ini pasti terbaca tanpa error
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
