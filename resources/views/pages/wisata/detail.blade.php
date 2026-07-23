@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-4 mb-10">

    <!-- Breadcrumb (Navigasi Jejak) -->
    <nav class="text-sm mb-6 text-gray-500 flex items-center space-x-2">
        <a href="{{ route('wisata.index') }}" class="hover:text-blue-600 transition font-medium">Katalog Wisata</a>
        <span>/</span>
        <span class="text-gray-800 font-bold">{{ $wisata->nama_wisata }}</span>
    </nav>

    <!-- Hero / Banner Gambar Slider dengan Alpine.js -->
    @php
    // Mengambil seluruh koleksi gambar wisata
    $galeri = $wisata->getMedia('wisata_images');
    @endphp

    <div class="w-full h-64 md:h-96 bg-gray-200 rounded-2xl overflow-hidden mb-8 shadow-sm relative group"
        @if($galeri->count() > 1)
        x-data="{
        activeSlide: 0,
        slides: {{ $galeri->count() }},
        autoSlide() {
        setInterval(() => {
        this.activeSlide = this.activeSlide === this.slides - 1 ? 0 : this.activeSlide + 1;
        }, 4000); // Gambar berganti otomatis setiap 4 detik
        }
        }"
        x-init="autoSlide()"
        @endif
        >
        @if($galeri->count() > 0)

        <!-- Looping Gambar -->
        @foreach($galeri as $index => $gambar)
        <div @if($galeri->count() > 1)
            x-show="activeSlide === {{ $index }}"
            x-transition.opacity.duration.700ms
            @endif
            class="absolute inset-0 w-full h-full">
            <img src="{{ $gambar->getUrl() }}" alt="{{ $wisata->nama_wisata }} - Gambar {{ $index + 1 }}" class="w-full h-full object-cover">
        </div>
        @endforeach

        <!-- Tombol Navigasi Manual & Indikator (Hanya muncul jika gambar > 1) -->
        @if($galeri->count() > 1)
        <!-- Tombol Kiri -->
        <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1"
            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white p-2.5 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Tombol Kanan -->
        <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1"
            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white p-2.5 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Titik Indikator Bawah -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
            @foreach($galeri as $index => $gambar)
            <button @click="activeSlide = {{ $index }}"
                :class="{'w-6 bg-white': activeSlide === {{ $index }}, 'w-2 bg-white/50 hover:bg-white/80': activeSlide !== {{ $index }}}"
                class="h-2 rounded-full transition-all duration-300 focus:outline-none">
            </button>
            @endforeach
        </div>
        @endif

        @else
        <!-- Placeholder jika belum ada gambar sama sekali -->
        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="font-medium text-sm">Belum Ada Gambar</p>
        </div>
        @endif
    </div>

    <!-- Layout Grid Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Kolom Kiri: Detail, Deskripsi, Fasilitas -->
        <div class="md:col-span-2 space-y-8">

            <!-- Judul & Jam Operasional -->
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 mb-3">{{ $wisata->nama_wisata }}</h1>
                <p class="text-blue-600 font-semibold flex items-center gap-1.5 bg-blue-50 w-fit px-3 py-1.5 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                    Jam Operasional: {{ $wisata->jam_operasional }}
                </p>
                <p class="text-gray-500 font-medium text-sm mt-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $wisata->lokasi }}
                </p>
            </div>

            <!-- Bagian Deskripsi -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 border-b border-gray-100 pb-2">Deskripsi Tempat Wisata</h3>
                <p class="text-gray-600 leading-relaxed text-justify text-md whitespace-pre-line">
                    {{ $wisata->deskripsi }}
                </p>
            </div>

            <!-- Bagian Fasilitas -->
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Fasilitas Tersedia</h3>
                <div class="flex flex-wrap gap-2">
                    <!-- Looping dari relasi database -->
                    @forelse ($wisata->fasilitas as $item)
                    <span class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <!-- Memanggil kolom nama_fasilitas -->
                        {{ $item->nama_fasilitas }}
                    </span>
                    @empty
                    <p class="text-gray-500 text-sm italic">Belum ada fasilitas yang ditambahkan.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Panel Pemesanan (Sticky) -->
        <div class="md:col-span-1">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm sticky top-6">

                <p class="text-gray-500 font-semibold mb-1 text-sm tracking-wide">Harga Tiket Masuk</p>
                <div class="flex items-end gap-1 mb-4">
                    <p class="text-4xl font-extrabold text-blue-700">Rp {{ number_format($wisata->harga_tiket, 0, ',', '.') }}</p>
                    <p class="text-gray-500 font-medium mb-1">/orang</p>
                </div>

                <!-- Info Sisa Tiket Hari Ini -->
                <div class="mb-6">
                    @if($wisata->sisa_tiket > 0)
                    <div class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded-lg text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Tersedia {{ $wisata->sisa_tiket }} tiket hari ini
                    </div>
                    @else
                    <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-lg text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        Tiket hari ini sudah habis terjual
                    </div>
                    @endif
                </div>

                <!-- Logika Tombol Pesan (Aktif / Mati) -->
                @if($wisata->sisa_tiket > 0)
                @auth
                <!-- Jika ada tiket & User Login -->
                <a href="{{ route('wisata.pesan', $wisata->id) }}" wire:navigate="false" data-turbo="false" class="block w-full bg-blue-700 text-white text-center font-bold py-3.5 px-4 rounded-xl hover:bg-blue-800 transition shadow-md hover:shadow-lg">
                    Pesan Tiket Sekarang
                </a>
                @else
                <!-- Jika ada tiket & User Belum Login -->
                <a href="{{ route('login') }}" wire:navigate="false" data-turbo="false" class="block w-full bg-blue-700 text-white text-center font-bold py-3.5 px-4 rounded-xl hover:bg-blue-800 transition shadow-md hover:shadow-lg">
                    Pesan Tiket Sekarang
                </a>
                @endauth
                @else
                <!-- Jika tiket habis -->
                <button disabled class="block w-full bg-gray-300 text-gray-500 text-center font-bold py-3.5 px-4 rounded-xl cursor-not-allowed">
                    Tiket Habis
                </button>
                @endif

                <div class="mt-4 flex items-center justify-center gap-2 text-xs font-semibold text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Pembayaran Aman & Diverifikasi
                </div>
            </div>
        </div>

    </div>
</div>
@endsection