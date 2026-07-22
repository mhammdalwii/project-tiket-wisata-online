@extends('layouts.app')

@section('content')
<!-- Section Hero & Pencarian -->
<div class="bg-blue-50 rounded-xl p-8 mb-10 text-center md:text-left">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Jelajahi Keindahan Wisata</h1>
    <p class="text-gray-600 mb-6">Pesan tiket sekarang dan nikmati liburanmu!</p>

    <!-- Search Form -->
    <!-- Action diubah agar mengarah ke halaman daftar wisata -->
    <form action="{{ route('wisata.index') }}" method="GET" class="flex flex-col md:flex-row max-w-lg gap-2">
        <input type="text" name="search" placeholder="Cari destinasi wisata..."
            class="flex-grow px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition font-medium">
            Cari
        </button>
    </form>
</div>

<!-- Section Destinasi Wisata -->
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Destinasi Wisata</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        @forelse ($wisatas as $wisata)
        <div class="bg-white border border-gray-200 rounded-lg flex flex-col justify-between shadow-sm hover:shadow-md transition overflow-hidden min-h-[250px]">

            <!-- Bagian Gambar Menggunakan Spatie Media Library -->
            <div class="w-full h-40 bg-gray-200 overflow-hidden relative">
                <!-- Jika ada gambar, tampilkan. Jika tidak, pakai warna abu-abu -->
                @if($wisata->getFirstMediaUrl('wisata'))
                <img src="{{ $wisata->getFirstMediaUrl('wisata') }}" alt="{{ $wisata->nama_wisata }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                @endif
            </div>

            <!-- Detail Destinasi -->
            <div class="p-5 flex flex-col flex-grow">
                <!-- Menggunakan kolom nama_wisata -->
                <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $wisata->nama_wisata }}</h3>

                <!-- Menggunakan kolom harga_tiket -->
                <p class="text-blue-600 font-extrabold mb-4">
                    Rp {{ number_format($wisata->harga_tiket, 0, ',', '.') }}
                </p>

                <div class="mt-auto">
                    <a href="{{ route('wisata.show', $wisata->id) }}" wire:navigate="false" data-turbo="false" class="block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm w-full text-center font-medium">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <!-- Tampilan jika database masih kosong -->
        <div class="col-span-1 md:col-span-2 lg:col-span-4 bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
            <p class="text-gray-500 font-medium">Belum ada data wisata yang ditambahkan.</p>
        </div>
        @endforelse

    </div>
</div>
@endsection