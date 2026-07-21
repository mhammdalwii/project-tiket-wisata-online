<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Tiket Wisata</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 antialiased font-sans flex flex-col min-h-screen">
    
    <!-- Navbar akan dipanggil di seluruh halaman yang menggunakan layout ini -->
    @include('components.ui.sections.navbar')

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>