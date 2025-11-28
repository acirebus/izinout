<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * mendaftarkan service aplikasi
     */
    public function register(): void
    {
    // tambahkan service aplikasi di sini
    }

    /**
     * bootstrap service aplikasi
     */
    public function boot(): void
    {
    // jalankan bootstrap aplikasi di sini
    }
}
