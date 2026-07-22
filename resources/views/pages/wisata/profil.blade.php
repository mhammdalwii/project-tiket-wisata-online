@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">

    <div class="flex items-center space-x-3 mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-semibold">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <!-- Form Utama -->
        <form action="{{ route('wisata.profil.update') }}" method="POST" enctype="multipart/form-data" wire:navigate="false" data-turbo="false">
            @csrf
            @method('PUT')

            <!-- x-data Alpine.js untuk fitur Preview Foto -->
            <div class="bg-blue-50 px-6 py-8 flex flex-col items-center justify-center border-b border-gray-200" x-data="{ photoPreview: null }">

                <!-- Lingkaran Foto -->
                <div class="w-24 h-24 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-md mb-3 overflow-hidden bg-blue-600">

                    <!-- Preview jika user memilih foto baru -->
                    <template x-if="photoPreview">
                        <img :src="photoPreview" class="w-full h-full object-cover">
                    </template>

                    <!-- Foto dari database atau Inisial jika belum ada -->
                    <template x-if="!photoPreview">
                        @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                        <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        @endif
                    </template>
                </div>

                <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>

                <!-- Input File Tersembunyi -->
                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*" x-ref="photo" @change="
                    const reader = new FileReader();
                    reader.onload = (e) => { photoPreview = e.target.result; };
                    reader.readAsDataURL($refs.photo.files[0]);
                ">

                <!-- Tombol yang memicu input file diklik -->
                <button type="button" @click="$refs.photo.click()" class="mt-4 bg-white border border-gray-300 text-gray-700 font-medium py-1.5 px-4 rounded-md text-sm hover:bg-gray-50 transition shadow-sm">
                    Ubah Foto Profil
                </button>
            </div>

            <!-- Form Edit Data -->
            <div class="p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Pribadi</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ auth()->user()->name }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-50 text-gray-500" readonly>
                        <span class="text-xs text-gray-400 mt-1 block">*Email tidak dapat diubah</span>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">No. Handphone</label>
                        <input type="tel" name="no_hp" value="{{ auth()->user()->phone }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" value="{{ auth()->user()->username }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 bg-gray-50 text-gray-500" readonly>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Keamanan</h3>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('wisata.index') }}" class="bg-white border border-gray-300 text-gray-700 font-bold py-2.5 px-6 rounded-md hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2.5 px-6 rounded-md hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection