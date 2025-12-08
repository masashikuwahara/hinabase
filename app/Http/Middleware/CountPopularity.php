<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Popularity;
use App\Models\PopularityDaily;
use App\Models\Member;
use App\Models\Song;

class CountPopularity
{
    private function isBot(?string $ua): bool {
        if (!$ua) return false;
        $ua = mb_strtolower($ua);
        foreach (['bot','crawl','spider','slurp','facebookexternalhit','bingpreview'] as $b) {
            if (str_contains($ua, $b)) return true;
        }
        return false;
    }

    private function resolveTypeAndId(Request $request): array|null
    {
        $name = optional($request->route())->getName();
        if (!in_array($name, ['members.show','songs.show'])) return null;

        if ($name === 'members.show') {
            $param = $request->route('member') ?? $request->route('id');
            $id = $param instanceof Member ? $param->getKey() : (int) $param;
            if ($id <= 0 || !Member::whereKey($id)->exists()) return null;
            return ['member', $id];
        } else {
            $param = $request->route('song') ?? $request->route('id');
            $id = $param instanceof Song ? $param->getKey() : (int) $param;
            if ($id <= 0 || !Song::whereKey($id)->exists()) return null;
            return ['song', $id];
        }
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->isBot($request->userAgent())) {
            return $next($request);
        }

        $resolved = $this->resolveTypeAndId($request);
        if ($resolved === null) {
            return $next($request);
        }
        [$type, $id] = $resolved;

        $response = $next($request);

        if ($response->isSuccessful()) {
            $record = Popularity::firstOrCreate(
                ['type' => $type, 'entity_id' => $id],
                ['views' => 0]
            );
            $record->increment('views');

            $today = Carbon::today(config('app.timezone'));
            $daily = PopularityDaily::firstOrCreate(
                ['type' => $type, 'entity_id' => $id, 'date' => $today],
                ['views' => 0]
            );
            $daily->increment('views');
        }

        return $response;
    }
}
