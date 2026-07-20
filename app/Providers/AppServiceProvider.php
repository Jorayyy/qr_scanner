<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 
use Illuminate\Pagination\Paginator; // 👈 🏆 IMPORTED FOR PACKAGING BUTTON LINKS

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
        // Keep your HTTPS force code block intact here...
        if (str_contains(request()->url(), 'ngrok-free.app') || config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // 🏆 UPDATE THIS LINE: Switches to clean, lightweight Previous/Next buttons
           \Illuminate\Pagination\Paginator::useBootstrapFive();
    }
}
