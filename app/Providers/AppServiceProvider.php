<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

// namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\URL; // <-- Tambahan: Impor Facade URL

// class AppServiceProvider extends ServiceProvider
// {
//     /**
//      * Register any application services.
//      */
//     public function register(): void
//     {
//         //
//     }

//     /**
//      * Bootstrap any application services.
//      */
//     public function boot(): void
//     {
//         // Tambahan: Memaksa Laravel memuat aset (CSS/JS) dengan awalan https://
//         // Ini sangat penting saat menggunakan Ngrok atau server produksi
//         if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https' || env('APP_ENV') == 'local') {
//             URL::forceScheme('https');
//         }
//     }
// }
