@extends('layouts.app')

@section('content')
    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Katalog Destinasi Wisata</h1>
        <p class="text-gray-600">Temukan berbagai destinasi wisata menarik di Desa Bahuluang dan pesan tiketmu sekarang.</p>
    </div>

    <!-- Menampilkan daftar wisata menggunakan perulangan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse ($daftar_wisata as $wisata)
            <!-- Memanggil komponen ticket-card dan mengirimkan variabel $wisata -->
            @include('components.ui.sections.ticket-card', ['wisata' => $wisata])
        @empty
            <div class="col-span-full text-center py-8 text-gray-500">
                Belum ada data destinasi wisata yang tersedia saat ini.
            </div>
        @endforelse
    </div>
@endsection