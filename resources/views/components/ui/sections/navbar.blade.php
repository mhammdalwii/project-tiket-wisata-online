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
            <!-- Tautan dummy untuk fitur yang belum kita buat halamannya -->
            <a href="{{ route('wisata.tiket-saya') }}" class="text-gray-700 font-medium hover:text-blue-600">Tiket Saya</a>
            <a href="{{ route('wisata.profil') }}" class="text-gray-700 font-medium hover:text-blue-600">Profil</a>
            
            <!-- Tombol Logout -->
            <form action="#" method="POST">
                @csrf
                <button type="submit" class="border border-blue-600 text-blue-600 px-4 py-1.5 rounded-md hover:bg-blue-50 transition font-medium">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>