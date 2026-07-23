@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-4 mb-10">

    <!-- Breadcrumb (Navigasi Jejak) -->
    <nav class="text-sm mb-6 text-gray-500 flex items-center space-x-2">
        <a href="{{ route('wisata.index') }}" class="hover:text-blue-600 transition font-medium">Katalog Wisata</a>
        <span>/</span>
        <span class="text-gray-800 font-bold">{{ $wisata->nama }}</span>
    </nav>

    <!-- Hero / Banner Gambar (Visual Dummy) -->
    <div class="w-full h-64 md:h-96 bg-blue-100 rounded-2xl overflow-hidden mb-8 shadow-sm flex items-center justify-center border border-blue-200">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-blue-500 font-medium text-sm">Preview Gambar Wisata</p>
        </div>
    </div>

    <!-- Layout Grid Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Kolom Kiri: Detail, Deskripsi, Fasilitas -->
        <div class="md:col-span-2 space-y-8">

            <!-- Judul & Jam Operasional -->
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 mb-3">{{ $wisata->nama }}</h1>
                <p class="text-blue-600 font-semibold flex items-center gap-1.5 bg-blue-50 w-fit px-3 py-1.5 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    Jam Operasional: {{ $wisata->jam_operasional }}
                </p>
            </div>

            <!-- Bagian Deskripsi -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 border-b border-gray-100 pb-2">Deskripsi Tempat Wisata</h3>
                <p class="text-gray-600 leading-relaxed text-justify text-md">
                    {{ $wisata->deskripsi }}
                </p>
            </div>

            <!-- Bagian Fasilitas -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Fasilitas Tersedia</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($wisata->fasilitas as $fasilitas)
                    <span class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        {{ $fasilitas }}
                    </span>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Panel Pemesanan (Sticky) -->
        <div class="md:col-span-1">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm sticky top-6">
                <p class="text-gray-500 font-semibold mb-1 text-sm tracking-wide">Harga Tiket Masuk</p>
                <div class="flex items-end gap-1 mb-6">
                    <p class="text-4xl font-extrabold text-blue-700">Rp {{ number_format($wisata->harga, 0, ',', '.') }}</p>
                    <p class="text-gray-500 font-medium mb-1">/orang</p>
                </div>

                <!-- Cek apakah pengguna sudah login -->
                @auth
                <!-- Jika SUDAH login, arahkan ke rute pemesanan -->
                <a href="{{ route('wisata.pesan', $wisata->id) }}" class="block w-full bg-blue-700 text-white text-center font-bold py-3.5 px-4 rounded-xl hover:bg-blue-800 transition shadow-md hover:shadow-lg">
                    Pesan Tiket Sekarang
                </a>
                @else
                <!-- Jika BELUM login (Guest), arahkan langsung ke halaman login -->
                <a href="{{ route('login') }}" class="block w-full bg-blue-700 text-white text-center font-bold py-3.5 px-4 rounded-xl hover:bg-blue-800 transition shadow-md hover:shadow-lg">
                    Pesan Tiket Sekarang
                </a>
                @endauth

                <div class="mt-4 flex items-center justify-center gap-2 text-xs font-semibold text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Pembayaran Aman & Diverifikasi Pokdarwis
                </div>
            </div>
        </div>

    </div>
</div>
@endsection