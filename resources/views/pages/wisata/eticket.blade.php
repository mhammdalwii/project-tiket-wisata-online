@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    
    <!-- Header E-Ticket -->
    <div class="flex items-center space-x-3 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-800">E-TICKET</h1>
    </div>

    <!-- Banner Success -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 flex items-start space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <p class="text-green-800 font-semibold">Pembayaran berhasil! Terima kasih.</p>
            <p class="text-green-700 text-sm">Tiket Anda sudah siap.</p>
        </div>
    </div>

    <!-- Tiket Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-8 flex flex-col md:flex-row gap-6">
        
        <!-- Detail Info -->
        <div class="flex-1 space-y-4 text-sm">
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Kode Booking</div>
                <div class="font-bold text-gray-900">: {{ $tiket->kode_booking }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Nama</div>
                <div class="font-semibold text-gray-800">: {{ $tiket->nama }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Destinasi</div>
                <div class="font-semibold text-gray-800">: {{ $tiket->destinasi }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Tanggal Kunjungan</div>
                <div class="font-semibold text-gray-800">: {{ $tiket->tanggal }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Waktu</div>
                <div class="font-semibold text-gray-800">: {{ $tiket->waktu }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Jumlah Tiket</div>
                <div class="font-semibold text-gray-800">: {{ $tiket->jumlah }} Orang</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-600">Total Pembayaran</div>
                <div class="font-semibold text-gray-800">: Rp {{ number_format($tiket->total, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="flex flex-col items-center justify-center border-t md:border-t-0 md:border-l border-dashed border-gray-300 pt-6 md:pt-0 md:pl-8">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $tiket->kode_booking }}" alt="QR Code" class="w-32 h-32 mb-3">
            <p class="text-xs text-center text-gray-500 w-32">Tunjukkan QR Code ini saat di loket</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 mb-8">
        <button type="button" class="flex-1 bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition text-center">
            DOWNLOAD PDF
        </button>
        <button type="button" class="flex-1 bg-white border border-gray-300 text-gray-800 font-bold py-3 px-4 rounded-md hover:bg-gray-50 transition text-center">
            CETAK TIKET
        </button>
    </div>

    <!-- Footer Note -->
    <div class="text-center text-sm text-gray-600 mb-8">
        <p>Terima kasih telah memesan di Tiket Wisata Online.</p>
        <p>Selamat menikmati perjalanan Anda!</p>
    </div>

</div>
@endsection