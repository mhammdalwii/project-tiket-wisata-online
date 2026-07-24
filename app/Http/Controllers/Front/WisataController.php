<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WisataController extends Controller
{
    // 0. Halaman Beranda (Dinamis dari Database)
    public function home()
    {
        $today = Carbon::today()->toDateString();

        // Mengambil 4 data wisata terbaru beserta jumlah tiket yang sudah terjual hari ini
        $wisatas = \App\Models\Wisata::withSum(['transaksis' => function ($query) use ($today) {
            $query->where('tanggal_kunjungan', $today)
                ->where('status_pembayaran', '!=', 'batal'); // Hitung semua kecuali yang batal
        }], 'jumlah_tiket')->latest()->take(4)->get();

        // Menyisipkan properti sisa_tiket ke setiap data
        foreach ($wisatas as $wisata) {
            $terjual = $wisata->transaksis_sum_jumlah_tiket ?? 0;
            $wisata->sisa_tiket = $wisata->kapasitas - $terjual;
        }

        return view('pages.home', compact('wisatas'));
    }

    // 1. Halaman Katalog Wisata (Beranda/Wisata)
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();

        // Mulai membangun query ke tabel wisatas beserta sum tiket terjual hari ini
        $query = \App\Models\Wisata::withSum(['transaksis' => function ($query) use ($today) {
            $query->where('tanggal_kunjungan', $today)
                ->where('status_pembayaran', '!=', 'batal');
        }], 'jumlah_tiket');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_wisata', 'like', '%' . $request->search . '%');
        }

        $daftar_wisata = $query->latest()->paginate(8);
        $daftar_wisata->appends($request->all());

        // Menyisipkan properti sisa_tiket
        foreach ($daftar_wisata as $wisata) {
            $terjual = $wisata->transaksis_sum_jumlah_tiket ?? 0;
            $wisata->sisa_tiket = $wisata->kapasitas - $terjual;
        }

        return view('pages.wisata.index', compact('daftar_wisata'));
    }

    // Fungsi Halaman Detail Wisata
    public function show($id)
    {
        $today = Carbon::today()->toDateString();

        // Mencari wisata beserta fasilitas dan sum tiket terjual hari ini
        $wisata = \App\Models\Wisata::with('fasilitas')
            ->withSum(['transaksis' => function ($query) use ($today) {
                $query->where('tanggal_kunjungan', $today)
                    ->where('status_pembayaran', '!=', 'batal');
            }], 'jumlah_tiket')
            ->findOrFail($id);

        $terjual = $wisata->transaksis_sum_jumlah_tiket ?? 0;
        $wisata->sisa_tiket = $wisata->kapasitas - $terjual;

        return view('pages.wisata.detail', compact('wisata'));
    }

    // 2. Halaman Form Pemesanan Tiket
    public function create($id)
    {
        // Mengambil data wisata asli dari database
        $wisata = \App\Models\Wisata::findOrFail($id);

        return view('pages.wisata.pesan', compact('wisata'));
    }

    // Memproses Data Pemesanan ke Database (Dengan Logika Anti-Overbooking)
    public function storePesan(Request $request)
    {
        $request->validate([
            'wisata_id' => 'required|exists:wisatas,id',
            'tanggal_kunjungan' => 'required|date',
            'waktu_kunjungan' => 'required',
            'jumlah_tiket' => 'required|integer|min:1',
            'total_harga' => 'required|numeric',
        ]);

        // 1. Ambil data wisata untuk mengecek kapasitas aslinya
        $wisata = \App\Models\Wisata::findOrFail($request->wisata_id);

        // 2. Hitung jumlah tiket yang SUDAH terjual di tanggal tersebut
        $tiketTerjualHariIni = \App\Models\Transaksi::where('wisata_id', $wisata->id)
            ->whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->where('status_pembayaran', '!=', 'batal') // Abaikan yang batal
            ->sum('jumlah_tiket');

        // 3. Hitung sisa tiket
        $sisaTiket = $wisata->kapasitas - $tiketTerjualHariIni;

        // 4. VALIDASI: Tolak jika pesanan melebihi sisa tiket
        if ($request->jumlah_tiket > $sisaTiket) {
            $tanggalFormat = Carbon::parse($request->tanggal_kunjungan)->translatedFormat('d F Y');

            if ($sisaTiket <= 0) {
                return back()->with('error', "Maaf, tiket untuk tanggal {$tanggalFormat} sudah habis terjual. Silakan pilih tanggal lain.");
            }

            return back()->with('error', "Maaf, tiket untuk tanggal {$tanggalFormat} hanya tersisa {$sisaTiket} tiket. Silakan kurangi jumlah pesanan Anda.");
        }

        // 5. Jika kuota aman, simpan transaksi (Menggunakan Auth::id() agar VS Code tidak error)
        $transaksi = \App\Models\Transaksi::create([
            'kode_booking' => 'BK-' . strtoupper(uniqid()),
            'user_id' => auth()->id(),
            'wisata_id' => $request->wisata_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'waktu_kunjungan' => $request->waktu_kunjungan,
            'jumlah_tiket' => $request->jumlah_tiket,
            'total_harga' => $request->total_harga,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        return redirect()->route('wisata.pembayaran', $transaksi->kode_booking);
    }


    // 3. Halaman Pembayaran
    public function pembayaran($kode_booking)
    {
        // Cari pesanan milik user yang sedang login
        $pesanan = \App\Models\Transaksi::where('kode_booking', $kode_booking)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('pages.wisata.pembayaran', compact('pesanan'));
    }

    // Memproses Upload Bukti Pembayaran
    public function storePembayaran(Request $request)
    {
        $request->validate([
            'kode_booking' => 'required|exists:transaksis,kode_booking',
            'metode_pembayaran' => 'required|in:Tunai,Transfer Bank BRI',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $transaksi = \App\Models\Transaksi::where('kode_booking', $request->kode_booking)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Update metode dan ubah status agar muncul di panel Admin untuk divalidasi
        $transaksi->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'menunggu_validasi'
        ]);

        // Upload ke Spatie Media Library menggunakan koleksi 'bukti_transfer' sesuai buatan Admin
        if ($request->hasFile('bukti_transfer') && $request->metode_pembayaran === 'Transfer Bank BRI') {
            $transaksi->addMediaFromRequest('bukti_transfer')->toMediaCollection('bukti_transfer');
        }

        return redirect()->route('wisata.tiket-saya')->with('success', 'Pesanan berhasil, silakan tunggu konfirmasi.');
    }

    // 4. Halaman Cetak / Lihat E-Ticket
    public function cetakTiket($id)
    {
        $tiket = \App\Models\Transaksi::with(['wisata', 'user'])->findOrFail($id);

        // Keamanan: Pastikan hanya pemilik tiket atau Admin yang bisa melihatnya
        if (auth()->id() !== $tiket->user_id && !auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses ke tiket ini.');
        }

        return view('pages.wisata.eticket', compact('tiket'));
    }

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
