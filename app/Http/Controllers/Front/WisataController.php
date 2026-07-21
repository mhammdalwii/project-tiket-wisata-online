<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WisataController extends Controller
{
    // 1. Halaman Katalog Wisata (Beranda/Wisata)
    public function index()
    {
        $daftar_wisata = [
            (object) ['id' => 1, 'nama' => 'Bone Bakka', 'harga' => 10000, 'gambar' => 'default.jpg'],
            (object) ['id' => 2, 'nama' => 'Bone Kidi', 'harga' => 15000, 'gambar' => 'default.jpg'],
            (object) ['id' => 3, 'nama' => 'Makam Karang', 'harga' => 5000, 'gambar' => 'default.jpg'],
            (object) ['id' => 4, 'nama' => 'Gua Lipang', 'harga' => 10000, 'gambar' => 'default.jpg'],
        ];

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
    public function tiketSaya()
    {
        $riwayat_tiket = [
            (object) [
                'kode_booking' => 'BK001',
                'destinasi' => 'Wisata Bahuluang',
                'tanggal' => '20 Agustus 2026',
                'jumlah' => 2,
                'total' => 10000,
                'status' => 'Lunas'
            ],
            (object) [
                'kode_booking' => 'BK002',
                'destinasi' => 'Bone Bakka',
                'tanggal' => '25 Agustus 2026',
                'jumlah' => 1,
                'total' => 15000,
                'status' => 'Menunggu Konfirmasi'
            ],
            (object) [
                'kode_booking' => 'BK003',
                'destinasi' => 'Gua Lipang',
                'tanggal' => '15 Agustus 2026',
                'jumlah' => 3,
                'total' => 30000,
                'status' => 'Dibatalkan'
            ]
        ];

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
}