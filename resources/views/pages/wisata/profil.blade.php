@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    
    <!-- Header Page -->
    <div class="flex items-center space-x-3 mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        
        <!-- Bagian Foto Profil (Visual Only) -->
        <div class="bg-blue-50 px-6 py-8 flex flex-col items-center justify-center border-b border-gray-200">
            <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-md mb-3">
                <!-- Inisial Nama -->
                {{ substr($user->nama_lengkap, 0, 1) }}
            </div>
            <h2 class="text-xl font-bold text-gray-800">{{ $user->nama_lengkap }}</h2>
            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
            
            <button class="mt-4 bg-white border border-gray-300 text-gray-700 font-medium py-1.5 px-4 rounded-md text-sm hover:bg-gray-50 transition">
                Ubah Foto Profil
            </button>
        </div>

        <!-- Form Edit Data -->
        <div class="p-6 md:p-8">
            <form action="#" method="POST">
                @csrf
                <!-- (Method PUT biasanya digunakan untuk update data di Laravel, tapi kita pakai statis dulu) -->
                
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Pribadi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-50 text-gray-500" readonly>
                        <span class="text-xs text-gray-400 mt-1 block">*Email tidak dapat diubah</span>
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">No. Handphone</label>
                        <input type="tel" name="no_hp" value="{{ $user->no_hp }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" value="{{ $user->username }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-50 text-gray-500" readonly>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Keamanan</h3>
                
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('wisata.index') }}" class="bg-white border border-gray-300 text-gray-700 font-bold py-2.5 px-6 rounded-md hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2.5 px-6 rounded-md hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection