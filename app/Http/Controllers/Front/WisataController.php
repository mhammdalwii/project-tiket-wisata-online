<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    // 0. Halaman Beranda (Dinamis dari Database)
    public function home()
    {
        // Mengambil 4 data wisata terbaru dari database
        $wisatas = \App\Models\Wisata::latest()->take(4)->get();

        return view('pages.home', compact('wisatas'));
    }

    // 1. Halaman Katalog Wisata (Beranda/Wisata)
    public function index(Request $request)
    {
        // Mulai membangun query ke tabel wisatas
        $query = \App\Models\Wisata::query();

        // Jika ada parameter 'search' di URL dan isinya tidak kosong
        if ($request->has('search') && $request->search != '') {
            // Filter berdasarkan kolom nama_wisata (case-insensitive)
            $query->where('nama_wisata', 'like', '%' . $request->search . '%');
        }

        // Ambil data terbaru. Kita gunakan paginate(8) agar jika datanya 
        // sudah ratusan, halamannya otomatis terbagi rapi
        $daftar_wisata = $query->latest()->paginate(8);

        // Tambahkan parameter pencarian ke fungsi pagination agar tidak hilang saat pindah halaman
        $daftar_wisata->appends($request->all());

        return view('pages.wisata.index', compact('daftar_wisata'));
    }

    // Fungsi Halaman Detail Wisata
    public function show($id)
    {
        // Dummy data detail wisata
        $wisata = (object) [
            'id' => $id,
            'nama' => 'Wisata Bahuluang',
            'deskripsi' => 'Nikmati keindahan alam yang asri dan udara sejuk di Wisata Bahuluang. Tempat wisata ini dikelola langsung oleh Pokdarwis setempat, menyajikan pemandangan bahari yang memukau dan kebudayaan lokal yang khas. Cocok untuk liburan santai bersama keluarga dan teman-teman.',
            'harga' => 10000,
            'jam_operasional' => '08:00 - 17:00 WITA',
            'fasilitas' => ['Area Parkir', 'Toilet Umum', 'Gazebo', 'Tempat Makan', 'Spot Foto'],
        ];

        return view('pages.wisata.detail', compact('wisata'));
    }

    // 2. Halaman Form Pemesanan Tiket
    public function create($id = null)
    {
        $wisata = (object) [
            'id' => $id ?? 1,
            'nama' => 'Wisata Bahuluang',
            'harga' => 10000
        ];

        return view('pages.wisata.pesan', compact('wisata'));
    }

    // 3. Halaman Pembayaran
    public function pembayaran()
    {
        $pesanan = (object) [
            'kode_booking' => 'BK001',
            'total' => 10000
        ];

        return view('pages.wisata.pembayaran', compact('pesanan'));
    }

    // 4. Halaman E-Ticket (Sukses Pembayaran)
    public function eticket()
    {
        $tiket = (object) [
            'kode_booking' => 'BK001',
            'nama' => 'Rosanti',
            'destinasi' => 'Wisata Bahuluang',
            'tanggal' => '20 Agustus 2026',
            'waktu' => '08.00 WIB',
            'jumlah' => 2,
            'total' => 10000
        ];

        return view('pages.wisata.eticket', compact('tiket'));
    }

    // 5. Halaman Riwayat / Tiket Saya
    // 5. Halaman Riwayat / Tiket Saya
    public function tiketSaya()
    {
        // Mengambil data transaksi dari database khusus untuk user yang sedang login
        // 'with('wisata')' digunakan untuk memuat relasi ke tabel wisatas sekaligus (Eager Loading)
        $riwayat_tiket = \App\Models\Transaksi::with('wisata')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.wisata.tiket-saya', compact('riwayat_tiket'));
    }

    // 6. Halaman Profil
    public function profil()
    {
        $user = (object) [
            'nama_lengkap' => 'Rosanti',
            'email' => 'rosanti@example.com',
            'no_hp' => '081234567890',
            'username' => 'rosanti_26'
        ];

        return view('pages.wisata.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        // Validasi data
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
            'password' => 'nullable|string|min:6',
        ]);

        // Update data dasar
        $user->name = $request->nama_lengkap;
        $user->phone = $request->no_hp;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Jika ada file foto yang diunggah
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            // Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
