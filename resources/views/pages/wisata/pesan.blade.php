@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mt-8">

    <div class="bg-blue-50 px-6 py-4 border-b border-gray-200 flex items-center space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <h2 class="text-lg font-bold text-gray-800">PEMESANAN TIKET</h2>
    </div>

    <div class="p-6">
        <!-- Action diubah ke rute POST (sementara kita beri nama rute imajiner yang nanti dibuat di backend) -->
        <form action="{{ route('wisata.pesan.store') }}" method="POST" id="formPemesanan" wire:navigate="false" data-turbo="false"
            x-data="{ jumlah: 2, hargaSatuan: {{ $wisata->harga_tiket ?? $wisata->harga }} }">
            @csrf

            <!-- Menampilkan Pesan Error Jika Tiket Habis -->
            @if(session('error'))
            <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg text-sm font-medium shadow-sm">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
            @endif

            <!-- Hidden Input untuk wisata_id -->
            <input type="hidden" name="wisata_id" value="{{ $wisata->id }}">

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Destinasi Wisata</label>
                <!-- Disesuaikan dengan nama kolom nama_wisata -->
                <input type="text" readonly value="{{ $wisata->nama_wisata ?? $wisata->nama }}"
                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700 focus:outline-none">
            </div>

            <!-- Input Tanggal & Waktu Kunjungan (Grid) -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                    <!-- name disesuaikan dengan kolom DB -->
                    <input type="date" name="tanggal_kunjungan" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu</label>
                    <!-- Tambahan input waktu karena di DB ada kolom waktu_kunjungan -->
                    <input type="time" name="waktu_kunjungan" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Tiket</label>
                <div class="flex items-center border border-gray-300 rounded-md w-32 overflow-hidden">
                    <button type="button" @click="if (jumlah > 1) jumlah--" class="w-10 h-10 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold transition flex items-center justify-center border-r border-gray-300">-</button>
                    <!-- name disesuaikan dengan kolom DB -->
                    <input type="number" name="jumlah_tiket" x-model="jumlah" min="1" readonly
                        class="w-12 h-10 text-center font-semibold text-gray-800 focus:outline-none bg-white">
                    <button type="button" @click="jumlah++" class="w-10 h-10 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold transition flex items-center justify-center border-l border-gray-300">+</button>
                </div>
            </div>

            <div class="border-t-2 border-dashed border-gray-200 my-6"></div>

            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-700 mb-1">Total Harga</p>
                <p class="text-2xl font-bold text-gray-900" x-text="'Rp ' + (jumlah * hargaSatuan).toLocaleString('id-ID')"></p>
                <!-- name disesuaikan dengan kolom DB -->
                <input type="hidden" name="total_harga" :value="jumlah * hargaSatuan">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition">
                LANJUT KE PEMBAYARAN
            </button>
        </form>
    </div>
</div>
@endsection