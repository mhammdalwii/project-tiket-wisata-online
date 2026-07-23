@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-8 print-area">

    <!-- Header E-Ticket -->
    <div class="flex items-center space-x-3 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-800">E-TICKET</h1>
    </div>

    <!-- Banner Success (Sembunyikan saat dicetak) -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 flex items-start space-x-3 no-print">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <p class="text-green-800 font-semibold">Pembayaran divalidasi! Terima kasih.</p>
            <p class="text-green-700 text-sm">Tiket Anda siap digunakan.</p>
        </div>
    </div>

    <!-- Tiket Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-8 flex flex-col md:flex-row gap-6 print-card">

        <!-- Detail Info -->
        <div class="flex-1 space-y-4 text-sm">
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Kode Booking</div>
                <div class="font-bold text-gray-900">: {{ $tiket->kode_booking }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Nama</div>
                <!-- Mengambil relasi dari tabel users -->
                <div class="font-semibold text-gray-800">: {{ $tiket->user->name }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Destinasi</div>
                <!-- Mengambil relasi dari tabel wisatas -->
                <div class="font-semibold text-gray-800">: {{ $tiket->wisata->nama_wisata }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Tanggal Kunjungan</div>
                <div class="font-semibold text-gray-800">: {{ \Carbon\Carbon::parse($tiket->tanggal_kunjungan)->translatedFormat('d F Y') }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Waktu</div>
                <div class="font-semibold text-gray-800">: {{ $tiket->waktu_kunjungan }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Jumlah Tiket</div>
                <div class="font-semibold text-gray-800">: {{ $tiket->jumlah_tiket }} Orang</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Total Pembayaran</div>
                <div class="font-semibold text-gray-800">: Rp {{ number_format($tiket->total_harga, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="flex flex-col items-center justify-center border-t md:border-t-0 md:border-l border-dashed border-gray-300 pt-6 md:pt-0 md:pl-8">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $tiket->kode_booking }}" alt="QR Code" class="w-32 h-32 mb-3">
            <p class="text-xs text-center text-gray-500 w-32">Tunjukkan QR Code ini saat di loket</p>
        </div>
    </div>

    <!-- Action Buttons (Sembunyikan saat dicetak) -->
    <div class="flex flex-col sm:flex-row gap-4 mb-8 no-print">
        <!-- Fungsi window.print() akan memanggil dialog save PDF/Print bawaan browser -->
        <button onclick="window.print()" type="button" class="flex-1 bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition text-center">
            DOWNLOAD PDF / CETAK TIKET
        </button>
        <a href="{{ route('wisata.tiket-saya') }}" class="flex-1 bg-white border border-gray-300 text-gray-800 font-bold py-3 px-4 rounded-md hover:bg-gray-50 transition text-center block">
            KEMBALI KE RIWAYAT
        </a>
    </div>

    <!-- Footer Note -->
    <div class="text-center text-sm text-gray-600 mb-8 print-footer">
        <p>Terima kasih telah memesan di Tiket Wisata Online.</p>
        <p>Selamat menikmati perjalanan Anda!</p>
    </div>

</div>

<!-- CSS khusus untuk Print/Download PDF -->
<style>
    @media print {

        /* Sembunyikan semua elemen di luar area print */
        body * {
            visibility: hidden;
        }

        /* Tampilkan hanya area tiket */
        .print-area,
        .print-area * {
            visibility: visible;
        }

        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        /* Sembunyikan elemen yang tidak perlu di kertas (Tombol, Navbar, Banner) */
        .no-print {
            display: none !important;
        }

        .print-card {
            box-shadow: none !important;
            border: 2px solid #e5e7eb !important;
        }
    }
</style>
@endsection