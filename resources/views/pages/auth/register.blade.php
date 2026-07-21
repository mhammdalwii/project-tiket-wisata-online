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
        <form action="#" method="POST">
            @csrf
            
            <!-- Input Nama Lengkap -->
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Nama Lengkap
                </label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-gray-700">
            </div>

            <!-- Input Email -->
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    Email
                </label>
                <input type="email" name="email" placeholder="Masukkan email" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-gray-700">
            </div>

            <!-- Input No. HP -->
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    No. HP
                </label>
                <input type="tel" name="no_hp" placeholder="Masukkan nomor HP" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-gray-700">
            </div>

            <!-- Input Username -->
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                    </svg>
                    Username
                </label>
                <input type="text" name="username" placeholder="Buat username" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-gray-700">
            </div>

            <!-- Input Password -->
            <div class="mb-8 relative">
                <label class="block text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    Password
                </label>
                <input type="password" id="inputPassword" name="password" placeholder="Buat password" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-gray-700 pr-10">
                
                <!-- Ikon Mata (Toggle Password) -->
                <button type="button" id="togglePassword" class="absolute right-3 top-[34px] p-1 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <!-- Tombol Register -->
            <button type="submit" class="w-full bg-blue-700 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-800 transition duration-200">
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

@push('scripts')
<script>
    // Fitur Tampilkan/Sembunyikan Password
    const togglePassword = document.getElementById('togglePassword');
    const inputPassword = document.getElementById('inputPassword');
    const eyeIcon = document.getElementById('eyeIcon');

    if(togglePassword) {
        togglePassword.addEventListener('click', function (e) {
            const type = inputPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            inputPassword.setAttribute('type', type);
            
            if(type === 'text') {
                eyeIcon.classList.add('text-blue-600');
                eyeIcon.classList.remove('text-gray-400');
            } else {
                eyeIcon.classList.add('text-gray-400');
                eyeIcon.classList.remove('text-blue-600');
            }
        });
    }
</script>
@endpush
@endsection