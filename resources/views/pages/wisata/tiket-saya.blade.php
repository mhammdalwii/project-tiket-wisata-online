@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8">

    <!-- Header Page -->
    <div class="flex items-center space-x-3 mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-900">Riwayat Tiket Saya</h1>
    </div>

    <!-- List Tiket -->
    <div class="space-y-6">
        @forelse ($riwayat_tiket as $tiket)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 md:p-6 flex flex-col md:flex-row md:items-center justify-between hover:shadow-md transition">

            <!-- Info Kiri -->
            <div class="flex-1 mb-4 md:mb-0">
                <div class="flex justify-between items-start md:block mb-2">
                    <span class="text-xs font-bold text-gray-500 tracking-wider">KODE: {{ $tiket->kode_booking }}</span>

                    <!-- Badge Status (Mobile View) -->
                    <div class="md:hidden">
                        @if ($tiket->status_pembayaran === 'lunas')
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Lunas</span>
                        @elseif (in_array($tiket->status_pembayaran, ['menunggu_pembayaran', 'menunggu_validasi']))
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">Menunggu</span>
                        @else
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Dibatalkan</span>
                        @endif
                    </div>
                </div>

                <!-- Mengambil nama wisata dari tabel relasi (wisatas) -->
                <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $tiket->wisata->nama_wisata }}</h3>
                <p class="text-sm text-gray-600 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <!-- Formatting tanggal menggunakan Carbon bawaan Laravel -->
                    {{ \Carbon\Carbon::parse($tiket->tanggal_kunjungan)->translatedFormat('d F Y') }} &bull; {{ $tiket->jumlah_tiket }} Tiket
                </p>
            </div>

            <!-- Harga dan Tombol Kanan -->
            <div class="flex flex-col md:items-end justify-between border-t md:border-t-0 border-gray-100 pt-4 md:pt-0">

                <!-- Badge Status (Desktop View) -->
                <div class="hidden md:block mb-3">
                    @if ($tiket->status_pembayaran === 'lunas')
                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full inline-block">Lunas</span>
                    @elseif (in_array($tiket->status_pembayaran, ['menunggu_pembayaran', 'menunggu_validasi']))
                    <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full inline-block">Menunggu Proses</span>
                    @else
                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full inline-block">Dibatalkan</span>
                    @endif
                </div>

                <div class="flex items-center justify-between md:flex-col md:items-end w-full">
                    <!-- Menggunakan kolom total_harga -->
                    <span class="text-lg font-bold text-gray-900 mb-2">Rp {{ number_format($tiket->total_harga, 0, ',', '.') }}</span>

                    <!-- Tombol Aksi -->
                    @if ($tiket->status_pembayaran === 'lunas')
                    <!-- Bypass pencegat Livewire SPA jika user mengklik tombol ini -->
                    <a href="{{ route('cetak.tiket', $tiket->id) }}" target="_blank" wire:navigate="false" data-turbo="false" class="text-sm bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700 transition">
                        Lihat E-Ticket
                    </a>
                    @elseif (in_array($tiket->status_pembayaran, ['menunggu_pembayaran', 'menunggu_validasi']))
                    <button disabled class="text-sm bg-gray-200 text-gray-500 font-semibold py-2 px-4 rounded-md cursor-not-allowed">
                        Sedang Diproses
                    </button>
                    @else
                    <button disabled class="text-sm bg-red-50 text-red-400 border border-red-200 font-semibold py-2 px-4 rounded-md cursor-not-allowed">
                        Pesanan Batal
                    </button>
                    @endif
                </div>
            </div>

        </div>
        @empty
        <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-10 text-center">
            <p class="text-gray-500 font-medium mb-4">Anda belum memiliki riwayat pemesanan tiket.</p>
            <a href="{{ route('wisata.index') }}" wire:navigate="false" data-turbo="false" class="inline-block bg-blue-600 text-white font-bold py-2 px-6 rounded-md hover:bg-blue-700 transition">
                Cari Wisata Sekarang
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection