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

        RateLimiter::for('members-limit', function ($request) {
            $memberId = (int) $request->route('id');
            $limitedMembers = [];
            $limit = 5;

            if (in_array($memberId, $limitedMembers, true)) {
                $key = "member_access_{$memberId}_" . now()->toDateString();
                $count = Cache::get($key, 0);

                if ($count >= $limit) {
                    abort(429);
                }

                Cache::put($key, $count + 1, now()->addDay()->startOfDay());
                return Limit::perMinute(30)->by('global');
            }

            return Limit::perMinute(30)->by($request->ip());
        });
    }
}
