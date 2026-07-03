<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 👈 Make sure this line is here at the top!

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
        // 👈 PASTE THIS EXACT LOGIC HERE
        // It detects ngrok or online links and forces them to use secure HTTPS
        if (str_contains(request()->url(), 'ngrok-free.app') || config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
