@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-2xl shadow-sm p-8">

        <div class="text-center mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 mx-auto text-blue-600 mb-3" viewBox="0 0 24 24" fill="currentColor">
                <path d="M14 6l-4.22 5.63 1.22 1.63L14 9.33l6 8H4l6-8 1.88 2.51 1.22-1.63L10 6.67 2.5 17.33A2 2 0 004 20h16a2 2 0 001.6-3.2L14 6z" />
            </svg>
            <h1 class="text-xl font-extrabold text-blue-800 tracking-wide mb-1">TIKET WISATA ONLINE</h1>
            <p class="text-gray-600 text-sm font-medium">Masuk untuk melanjutkan</p>
        </div>

        <form action="{{ route('login.process') }}" method="POST" wire:navigate="false" data-turbo="false">
            @csrf

            <!-- Tampilkan Error jika Username/Password Salah -->
            @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg text-center font-medium">
                {{ $errors->first() }}
            </div>
            @endif

            <div class="mb-5">
                <label class="block text-sm font-bold text-gray-800 mb-2">Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-gray-700">
            </div>

            <!-- Inisialisasi Alpine.js state: showPassword -->
            <div class="mb-6 relative" x-data="{ showPassword: false }">
                <label class="block text-sm font-bold text-gray-800 mb-2">Password</label>

                <!-- Binding type berdasarkan state showPassword -->
                <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Masukkan password" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-gray-700 pr-10">

                <!-- Toggle saat tombol diklik -->
                <button type="button" @click="showPassword = !showPassword"
                    class="absolute right-3 top-[34px] p-1 focus:outline-none transition-colors"
                    :class="showPassword ? 'text-blue-600' : 'text-gray-400 hover:text-gray-600'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <button type="submit" class="w-full bg-blue-700 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-800 transition duration-200">
                LOGIN
            </button>
        </form>

        <div class="mt-8 text-center text-sm">
            <span class="text-gray-600">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-blue-700 font-bold hover:underline ml-1">Registrasi di sini</a>
        </div>
    </div>
</div>
@endsection