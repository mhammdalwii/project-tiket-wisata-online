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
            
            <!-- Card 1: Bone Bakka -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col items-center justify-between shadow-sm hover:shadow-md transition min-h-[150px]">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Bone Bakka</h3>
                <!-- href sudah dihubungkan ke route pesan -->
                <a href="{{ route('wisata.show', 1) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm w-full text-center">
                    Lihat Detail
                </a>
            </div>

            <!-- Card 2: Bone Kidi -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col items-center justify-between shadow-sm hover:shadow-md transition min-h-[150px]">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Bone Kidi</h3>
                <a href="{{ route('wisata.show', 2) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm w-full text-center">
                    Lihat Detail
                </a>
            </div>

            <!-- Card 3: Makam Karang -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col items-center justify-between shadow-sm hover:shadow-md transition min-h-[150px]">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Makam Karang</h3>
                <a href="{{ route('wisata.show', 3) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm w-full text-center">
                    Lihat Detail
                </a>
            </div>

            <!-- Card 4: Gua Lipang -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col items-center justify-between shadow-sm hover:shadow-md transition min-h-[150px]">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Gua Lipang</h3>
                <a href="{{ route('wisata.show', 4) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm w-full text-center">
                    Lihat Detail
                </a>
            </div>

        </div>
    </div>
@endsection