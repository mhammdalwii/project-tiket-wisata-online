@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-8">
    <div class="w-full max-w-md bg-white border border-gray-200 rounded-2xl shadow-sm p-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <!-- Ikon User -->
            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
            </div>
            <h1 class="text-xl font-extrabold text-gray-900 tracking-wide mb-1">REGISTRASI AKUN</h1>
            <p class="text-gray-600 text-sm font-medium">Buat akun baru</p>
        </div>

        <!-- Form Registrasi -->
        <form action="{{ route('register.process') }}" method="POST" wire:navigate="false" data-turbo="false">
            @csrf

            <!-- Input Nama Lengkap -->
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-800 mb-2">Nama Lengkap</label>
                <!-- Atribut name="nama_lengkap" -->
                <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-gray-700">
            </div>

            <!-- Input Email -->
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-800 mb-2">Email</label>
                <!-- Atribut name="email" -->
                <input type="email" name="email" placeholder="Masukkan email aktif" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-gray-700">
            </div>

            <!-- Input No. HP -->
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-800 mb-2">Nomor HP</label>
                <!-- Atribut name="no_hp" -->
                <input type="text" name="no_hp" placeholder="Contoh: 08123456789" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-gray-700">
            </div>

            <!-- Input Username -->
            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-800 mb-2">Username</label>
                <!-- Atribut name="username" -->
                <input type="text" name="username" placeholder="Buat username" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-gray-700">
            </div>

            <!-- Input Password (Dengan Alpine.js yang sudah kita buat sebelumnya) -->
            <div class="mb-8 relative" x-data="{ showPassword: false }">
                <label class="block text-sm font-bold text-gray-800 mb-2">Password</label>
                <!-- Atribut name="password" -->
                <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Buat password (min. 6 karakter)" required minlength="6"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-gray-700 pr-10">

                <button type="button" @click="showPassword = !showPassword"
                    class="absolute right-3 top-[34px] p-1 focus:outline-none transition-colors"
                    :class="showPassword ? 'text-blue-600' : 'text-gray-400 hover:text-gray-600'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <button type="submit" class="w-full bg-blue-700 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-800 transition duration-200 shadow-md">
                DAFTAR SEKARANG
            </button>
        </form>

        <!-- Link Login -->
        <div class="mt-8 text-center text-sm">
            <span class="text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-blue-700 font-bold hover:underline ml-1">Login di sini</a>
        </div>

    </div>
</div>
@endsection