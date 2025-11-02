<?php

namespace App\Providers;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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
    public function boot()
    {
        RateLimiter::for('songs-limit', function ($request) {
            $ip = $request->ip();
            $songId = $request->route('id');

            if ($songId == 150) {
                return [
                    Limit::perMinute(1)->by($ip),
                ];
            }

            return [
                Limit::perMinute(30)->by($ip),
            ];
        });
    }
}
