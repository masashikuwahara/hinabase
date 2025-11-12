<?php

namespace App\Providers;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
    // public function boot()
    // {
    //     RateLimiter::for('songs-limit', function ($request) {
    //         $ip = $request->ip();
    //         $songId = $request->route('id');

    //         if ($songId == 150) {
    //             return [
    //                 Limit::perMinute(1,1440)->by($ip),
    //             ];
    //         }

    //         return [
    //             Limit::perMinute(30)->by($ip),
    //         ];
    //     });
    // }

    public function boot()
    {
        RateLimiter::for('songs-limit', function ($request) {
            $songId = $request->route('id');
                Log::info('RateLimiter executed', [
        'songId' => $songId,
        'ip' => $request->ip(),
    ]);

    if ($songId == 150) {
        $key = 'song150_access_' . now()->toDateString();
        $count = Cache::get($key, 0);
        $limit = 3;

        if ($count >= $limit) {
            return Limit::perMinute(1)->by('global')->response(function () {
                abort(429);
            });
        }

        $expiresAt = now()->addDay()->startOfDay();
        Cache::put($key, $count + 1, $expiresAt);
        return [Limit::perMinute(30)];
    }

    return [
        Limit::perMinute(60)->by($request->ip()),
    ];
    });
  }
}
