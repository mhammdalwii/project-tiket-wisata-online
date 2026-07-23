@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-3">
        <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
        <span class="text-gray-900 font-semibold">Katalog Wisata</span>
    </nav>
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Katalog Destinasi Wisata</h1>
            <p class="text-gray-500 mt-1.5">Temukan berbagai destinasi wisata menarik dan pesan tiketmu sekarang</p>
        </div>
        @if($daftar_wisata->total() > 0)
        <p class="text-sm text-gray-400 whitespace-nowrap">
            <span class="font-semibold text-gray-600">{{ $daftar_wisata->total() }}</span> destinasi ditemukan
        </p>
        @endif
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="bg-white border border-gray-100 rounded-xl p-4 sm:p-5 mb-8 shadow-sm">
    <form action="{{ route('wisata.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-grow">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari destinasi wisata..."
                class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
            Cari
        </button>
        @if(request('search'))
        <a href="{{ route('wisata.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Reset
        </a>
        @endif
    </form>
</div>

<!-- Grid Katalog Wisata -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse ($daftar_wisata as $wisata)
    <div class="bg-white border border-gray-100 rounded-xl flex flex-col justify-between shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group hover:-translate-y-1">

        @php
        $galeri = $wisata->getMedia('wisata_images');
        @endphp

        <div class="w-full h-48 bg-gray-200 overflow-hidden relative"
            @if($galeri->count() > 1)
            x-data="{
            activeSlide: 0,
            slides: {{ $galeri->count() }},
            autoSlide() {
            setInterval(() => {
            this.activeSlide = this.activeSlide === this.slides - 1 ? 0 : this.activeSlide + 1;
            }, 4000);
            }
            }"
            x-init="autoSlide()"
            @endif
            >
            @if($galeri->count() > 0)

            @foreach($galeri as $index => $gambar)
            <div @if($galeri->count() > 1)
                x-show="activeSlide === {{ $index }}"
                x-transition.opacity.duration.700ms
                @endif
                class="absolute inset-0 w-full h-full">
                <img src="{{ $gambar->getUrl() }}" alt="{{ $wisata->nama_wisata }} - Gambar {{ $index + 1 }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            @endforeach

            @if($galeri->count() > 1)
            <button @click.prevent="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white p-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 focus:outline-none z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button @click.prevent="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white p-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 focus:outline-none z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex space-x-1.5 z-10">
                @foreach($galeri as $index => $gambar)
                <button @click.prevent="activeSlide = {{ $index }}"
                    :class="{'w-4 bg-white': activeSlide === {{ $index }}, 'w-1.5 bg-white/50 hover:bg-white/80': activeSlide !== {{ $index }}}"
                    class="h-1.5 rounded-full transition-all duration-300 focus:outline-none">
                </button>
                @endforeach
            </div>
            @endif

            @else
            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="font-medium text-xs">No Image</p>
            </div>
            @endif

            <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>

            <div class="absolute top-3 right-3 z-20">
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
    <div class="col-span-full bg-gray-50 border border-gray-200 rounded-xl p-12 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <p class="text-gray-500 font-semibold text-lg mb-1">Destinasi tidak ditemukan</p>
        <p class="text-gray-400 text-sm">Coba gunakan kata kunci lain untuk mencari destinasi wisata.</p>
        @if(request('search'))
        <a href="{{ route('wisata.index') }}" class="inline-flex items-center gap-2 mt-5 text-sm font-semibold text-blue-600 bg-blue-50 px-5 py-2.5 rounded-lg hover:bg-blue-100 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Semua Wisata
        </a>
        @endif
    </div>
    @endforelse
</div>

@if($daftar_wisata->hasPages())
<div class="mt-10 border-t border-gray-100 pt-6">
    {{ $daftar_wisata->links() }}
</div>
@endif
@endsection