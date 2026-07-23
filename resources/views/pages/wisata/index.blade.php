@extends('layouts.app')

@section('content')
<div class="mb-8 text-center md:text-left">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Katalog Destinasi Wisata</h1>
    <p class="text-gray-600">Temukan berbagai destinasi wisata menarik di Desa Bahuluang dan pesan tiketmu sekarang.</p>
</div>

<!-- Menampilkan daftar wisata menggunakan perulangan -->
<form action="{{ route('wisata.index') }}" method="GET" class="mb-8 flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari destinasi wisata..." class="px-4 py-2 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-blue-500">
    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Cari</button>
</form>

<!-- Grid Katalog Wisata -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse ($daftar_wisata as $wisata)
    <div class="bg-white border border-gray-200 rounded-lg flex flex-col justify-between shadow-sm hover:shadow-md transition overflow-hidden min-h-[250px]">

        <!-- Gambar Spatie Media -->
        <div class="w-full h-40 bg-gray-200 overflow-hidden relative">
            @if($wisata->getFirstMediaUrl('wisata'))
            <img src="{{ $wisata->getFirstMediaUrl('wisata') }}" alt="{{ $wisata->nama_wisata }}" class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <span>No Image</span>
            </div>
            @endif
        </div>

        <div class="p-5 flex flex-col flex-grow">
            <!-- Kolom DB: nama_wisata dan harga_tiket -->
            <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $wisata->nama_wisata }}</h3>
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
    <div class="col-span-full bg-gray-50 border border-gray-200 rounded-lg p-8 text-center text-gray-500">
        Destinasi wisata yang Anda cari tidak ditemukan.
    </div>
    @endforelse
</div>

<!-- Navigasi Pagination -->
<div class="mt-8">
    {{ $daftar_wisata->links() }}
</div>
@endsection