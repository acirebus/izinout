<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * path ke route "home" aplikasi.
     *
     * biasanya, user diarahkan ke sini setelah login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * mendefinisikan binding model route, filter pola, dan konfigurasi route lain.
     */
    public function boot(): void
    {
    // konfigurasi tambahan route
    }
}