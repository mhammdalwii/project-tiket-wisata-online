@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mt-8">
    
    <!-- Header -->
    <div class="bg-blue-50 px-6 py-4 border-b border-gray-200 flex items-center space-x-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
        </svg>
        <h2 class="text-lg font-bold text-gray-800">PEMBAYARAN TIKET</h2>
    </div>

    <div class="p-6">
        <!-- Ringkasan Pemesanan -->
        <div class="bg-blue-50/50 border border-blue-100 rounded-lg p-4 mb-6">
            <div class="grid grid-cols-3 gap-2 text-sm mb-2">
                <div class="text-gray-600 font-medium">Kode Booking</div>
                <div class="col-span-2 font-bold text-gray-900">: {{ $pesanan->kode_booking }}</div>
            </div>
            <div class="grid grid-cols-3 gap-2 text-sm">
                <div class="text-gray-600 font-medium">Total Bayar</div>
                <div class="col-span-2 font-bold text-blue-700">: Rp {{ number_format($pesanan->total, 0, ',', '.') }}</div>
            </div>
        </div>

        <form action="{{ route('wisata.eticket') }}" method="GET" enctype="multipart/form-data">
            @csrf

            <!-- Metode Pembayaran -->
            <div class="mb-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Metode Pembayaran</h3>
                
                <div class="space-y-3">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="metode" value="tunai" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" onclick="toggleBankInfo(false)">
                        <span class="text-gray-800 text-sm">Tunai (Bayar di Loket)</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="metode" value="transfer" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked onclick="toggleBankInfo(true)">
                        <span class="text-gray-800 text-sm">Transfer Bank BRI</span>
                    </label>
                </div>
            </div>

            <!-- Detail Bank (Akan disembunyikan jika pilih tunai) -->
            <div id="bankInfo" class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6 text-sm">
                <div class="grid grid-cols-3 gap-2 mb-1">
                    <div class="text-gray-600">Bank</div>
                    <div class="col-span-2 font-semibold text-gray-800">: BRI</div>
                </div>
                <div class="grid grid-cols-3 gap-2 mb-1">
                    <div class="text-gray-600">No. Rekening</div>
                    <div class="col-span-2 font-semibold text-gray-800">: 1234 5678 9012 3456</div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div class="text-gray-600">Atas Nama</div>
                    <div class="col-span-2 font-semibold text-gray-800">: Pokdarwis Bahuluang</div>
                </div>
            </div>

            <!-- Upload Bukti -->
            <div class="mb-6" id="uploadSection">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Upload Bukti Transfer</h3>
                <input type="file" name="bukti_transfer" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-md p-1">
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition mb-2">
                KONFIRMASI PEMBAYARAN
            </button>
            <p class="text-xs text-red-500 font-medium">* Pastikan bukti transfer terlihat jelas</p>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Fungsi untuk menyembunyikan/menampilkan info bank dan upload bukti
    function toggleBankInfo(isTransfer) {
        const bankInfo = document.getElementById('bankInfo');
        const uploadSection = document.getElementById('uploadSection');
        
        if (isTransfer) {
            bankInfo.style.display = 'block';
            uploadSection.style.display = 'block';
        } else {
            bankInfo.style.display = 'none';
            uploadSection.style.display = 'none';
        }
    }
</script>
@endpush
@endsection