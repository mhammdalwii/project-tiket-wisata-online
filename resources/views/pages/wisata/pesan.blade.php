@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mt-8">
    
    <!-- Header Form -->
    <div class="bg-blue-50 px-6 py-4 border-b border-gray-200 flex items-center space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <h2 class="text-lg font-bold text-gray-800">PEMESANAN TIKET</h2>
    </div>

    <!-- Body Form -->
    <div class="p-6">
        <form action="{{ route('wisata.pembayaran') }}" method="GET" id="formPemesanan">
            @csrf
            
            <!-- Input Destinasi Wisata -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Destinasi Wisata</label>
                <!-- Dibuat readonly karena anggapannya user sudah memilih wisata dari halaman sebelumnya -->
                <input type="text" readonly value="{{ $wisata->nama }}" 
                       class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700 focus:outline-none">
            </div>

            <!-- Input Tanggal Kunjungan -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kunjungan</label>
                <input type="date" name="tanggal" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Input Jumlah Tiket -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Tiket</label>
                <div class="flex items-center border border-gray-300 rounded-md w-32 overflow-hidden">
                    <button type="button" id="btnMin" class="w-10 h-10 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold transition flex items-center justify-center border-r border-gray-300">
                        -
                    </button>
                    <input type="number" id="inputJumlah" name="jumlah" value="2" min="1" readonly
                           class="w-12 h-10 text-center font-semibold text-gray-800 focus:outline-none bg-white">
                    <button type="button" id="btnPlus" class="w-10 h-10 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold transition flex items-center justify-center border-l border-gray-300">
                        +
                    </button>
                </div>
            </div>

            <!-- Garis Putus-putus -->
            <div class="border-t-2 border-dashed border-gray-200 my-6"></div>

            <!-- Total Harga -->
            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-700 mb-1">Total Harga</p>
                <p class="text-2xl font-bold text-gray-900" id="textTotal">Rp 10.000</p>
                <!-- Hidden input untuk dikirim ke backend -->
                <input type="hidden" name="total_harga" id="inputTotal" value="10000">
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition">
                PESAN SEKARANG
            </button>
        </form>
    </div>
</div>

<!-- Script Sederhana untuk Kalkulasi -->
 @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hargaSatuan = {{ $wisata->harga }};
        const inputJumlah = document.getElementById('inputJumlah');
        const textTotal = document.getElementById('textTotal');
        const inputTotal = document.getElementById('inputTotal');
        const btnMin = document.getElementById('btnMin');
        const btnPlus = document.getElementById('btnPlus');

        // Fungsi format Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Fungsi Update Total
        function updateTotal() {
            let jumlah = parseInt(inputJumlah.value);
            let total = jumlah * hargaSatuan;
            textTotal.textContent = formatRupiah(total);
            inputTotal.value = total;
        }

        btnPlus.addEventListener('click', function() {
            inputJumlah.value = parseInt(inputJumlah.value) + 1;
            updateTotal();
        });

        btnMin.addEventListener('click', function() {
            if (parseInt(inputJumlah.value) > 1) {
                inputJumlah.value = parseInt(inputJumlah.value) - 1;
                updateTotal();
            }
        });

        // Panggil sekali saat load
        updateTotal();
    });
</script>
@endpush
@endsection