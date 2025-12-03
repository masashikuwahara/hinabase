<?php

namespace App\Providers;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

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
            $songId = (int) $request->route('id');
            
            $limitedIds = [150, 147];
            $limit = 2;
            if (in_array($songId, $limitedIds, true)) {
                $key = "song_access_{$songId}_" . now()->toDateString();
                $count = Cache::get($key, 0);
                if ($count >= $limit) {
                    abort(429);
                }

                Cache::put($key, $count + 1, now()->addDay()->startOfDay());
                return Limit::perMinute(30)->by('global'); // 形式上
            }
            return Limit::perMinute(30)->by($request->ip());
        });
    }
    // public function boot()
    // {
    //     RateLimiter::for('songs-limit', function ($request) {
    //         $songId = (int)$request->route('id');
            
    //         if ($songId === 150) {
    //             $key = 'song150_' . now()->toDateString();
    //             return [
    //                 Limit::perMinutes(1440, 2)
    //                 ->by($key)
    //                 ->response(function () {
    //                     abort(429);
    //                 }),
    //             ];
    //         }
            
    //         return [
    //             Limit::perMinute(60)->by($request->ip()),
    //         ];
    //     });
    // }
}
