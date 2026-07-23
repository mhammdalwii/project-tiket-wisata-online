<nav class="bg-white shadow-sm py-4">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <!-- Logo / Judul -->
        <a href="{{ url('/') }}" class="text-xl font-bold text-blue-700">
            TIKET WISATA ONLINE
        </a>

        <!-- Menu Navigasi -->
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ url('/') }}" class="text-gray-700 font-medium hover:text-blue-600">Beranda</a>
            <a href="{{ route('wisata.index') }}" class="text-gray-700 font-medium hover:text-blue-600">Wisata</a>

            <!-- JIKA PENGGUNA BELUM LOGIN -->
            @guest
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition font-medium shadow-sm">
                Login
            </a>
            @endguest

            <!-- JIKA PENGGUNA SUDAH LOGIN -->
            @auth
            <a href="{{ route('wisata.tiket-saya') }}" class="text-gray-700 font-medium hover:text-blue-600">Tiket Saya</a>

            <!-- Dropdown Profil dengan Alpine.js -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 text-gray-700 font-medium hover:text-blue-600 focus:outline-none bg-blue-50 px-4 py-2 rounded-md">
                    <!-- Menampilkan nama pengguna dari database -->
                    <span>Halo, {{ Auth::user()->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Isi Dropdown -->
                <div x-show="open" x-transition.opacity class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-50" style="display: none;">
                    <a href="{{ route('wisata.profil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700">Profil Saya</a>

                    <form action="{{ route('logout') }}" method="POST" class="block border-t border-gray-100 mt-1 pt-1">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</nav>