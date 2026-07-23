@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl p-8 sm:p-12 mb-12">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-blue-300 rounded-full blur-3xl"></div>
    </div>
    <div class="relative z-10 text-center sm:text-left">
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">Jelajahi Keindahan Wisata</h1>
        <p class="text-blue-100 text-base sm:text-lg mb-7 max-w-xl">Pesan tiket sekarang dan nikmati liburanmu bersama keluarga & teman-teman!</p>
        <form action="{{ route('wisata.index') }}" method="GET" class="flex flex-col sm:flex-row max-w-lg gap-3">
            <div class="relative flex-grow">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
                <input type="text" name="search" placeholder="Cari destinasi wisata..."
                    class="w-full pl-11 pr-4 py-3 bg-white/95 backdrop-blur-sm border-0 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm text-gray-900 placeholder-gray-400">
            </div>
            <button type="submit" class="bg-white text-blue-700 px-8 py-3 rounded-xl hover:bg-blue-50 transition-all duration-300 font-bold shadow-sm hover:shadow-md">
                Cari
            </button>
        </form>
    </div>
</div>

<!-- Section Destinasi Wisata -->
<div class="mb-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Destinasi Wisata</h2>
            <p class="text-sm text-gray-500 mt-1">Destinasi wisata populer pilihan untuk Anda</p>
        </div>
        <a href="{{ route('wisata.index') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors group/link">
            Lihat Semua
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        @forelse ($wisatas as $wisata)
        <div class="bg-white border border-gray-100 rounded-xl flex flex-col justify-between shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group hover:-translate-y-1">

            <div class="w-full h-48 bg-gray-200 overflow-hidden relative">
                @if($wisata->getFirstMediaUrl('wisata_images'))
                <img src="{{ $wisata->getFirstMediaUrl('wisata_images') }}" alt="{{ $wisata->nama_wisata }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                @endif

                <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/40 to-transparent"></div>

                <div class="absolute top-3 right-3 z-10">
                    @if($wisata->sisa_tiket > 0)
                    <span class="bg-emerald-500/90 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                        Sisa Tiket: {{ $wisata->sisa_tiket }}
                    </span>
                    @else
                    <span class="bg-red-500/90 backdrop-blur-md text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">
                        Hari Ini Penuh
                    </span>
                    @endif
                </div>
            </div>

            <div class="p-5 flex flex-col flex-grow">
                <div class="flex flex-col gap-1 mb-3">
                    @if($wisata->lokasi)
                    <div class="flex items-center gap-1.5 text-gray-500 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span class="truncate">{{ $wisata->lokasi }}</span>
                    </div>
                    @endif
                    @if($wisata->jam_operasional)
                    <div class="flex items-center gap-1.5 text-gray-500 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $wisata->jam_operasional }}</span>
                    </div>
                    @endif
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-1 leading-snug">{{ $wisata->nama_wisata }}</h3>
                <p class="text-blue-600 font-extrabold text-base mb-4">
                    Rp {{ number_format($wisata->harga_tiket, 0, ',', '.') }}
                </p>

                <div class="mt-auto">
                    @if($wisata->sisa_tiket > 0)
                    <a href="{{ route('wisata.show', $wisata->id) }}" wire:navigate="false" data-turbo="false"
                        class="group/btn flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition-all duration-300 text-sm w-full text-center font-semibold shadow-sm hover:shadow-md">
                        Lihat Detail
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @else
                    <button disabled class="block bg-gray-100 text-gray-400 px-4 py-2.5 rounded-lg text-sm w-full text-center font-semibold cursor-not-allowed border border-gray-200">
                        Tiket Habis
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-1 sm:col-span-2 lg:col-span-4 bg-gray-50 border border-gray-200 rounded-xl p-10 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <p class="text-gray-500 font-medium">Belum ada data wisata yang ditambahkan.</p>
        </div>
        @endforelse

    </div>
</div>
@endsection