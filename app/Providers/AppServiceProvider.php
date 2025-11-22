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
            $songId = (int)$request->route('id');
            
            if ($songId === 150) {
                $key = 'song150_' . now()->toDateString();
                return [
                    Limit::perMinutes(1440, 3)
                    ->by($key)
                    ->response(function () {
                        abort(429);
                    }),
                ];
            }
            
            return [
                Limit::perMinute(60)->by($request->ip()),
            ];
        });
    }
}
