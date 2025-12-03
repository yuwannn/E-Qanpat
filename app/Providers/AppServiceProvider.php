<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        Paginator::useBootstrapFive();

        // 2. TAMBAHKAN KODE INI:
        // Jika aplikasi berjalan di environment 'production' (Railway), paksa pakai HTTPS
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
