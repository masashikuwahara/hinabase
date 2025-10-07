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
        $bots = ['bot','crawl','spider','slurp','facebookexternalhit','bingpreview'];
        $ua = mb_strtolower($ua);
        foreach ($bots as $b) if (str_contains($ua, $b)) return true;
        return false;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $name = optional($request->route())->getName();
        if (!in_array($name, ['members.show','songs.show'])) return $response;
        if ($this->isBot($request->userAgent())) return $response;

        // ID解決（{member}/{song} でも {id} でもOK）
        if ($name === 'members.show') {
            $param = $request->route('member') ?? $request->route('id');
            $id = $param instanceof Member ? $param->getKey() : (int) $param;
            $type = 'member';
        } else {
            $param = $request->route('song') ?? $request->route('id');
            $id = $param instanceof Song ? $param->getKey() : (int) $param;
            $type = 'song';
        }

        $record = Popularity::firstOrCreate(
            ['type' => $type, 'entity_id' => $id],
            ['views' => 0]
        );
        $record->increment('views');

        $today = Carbon::today();
        $daily = PopularityDaily::firstOrCreate(
            ['type' => $type, 'entity_id' => $id, 'date' => $today],
            ['views' => 0]
        );
        $daily->increment('views');

        return $response;
    }
}
// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use App\Models\Popularity;
// use App\Models\Member;
// use App\Models\Song;

// class CountPopularity
// {
//     public function handle(Request $request, Closure $next)
//     {
//         $response = $next($request);

//         $name = optional($request->route())->getName();
//         if (!in_array($name, ['members.show','songs.show'])) return $response;

//         if ($name === 'members.show') {
//             $param = $request->route('member');
//             $id = $param instanceof Member ? $param->getKey() : (int) $param;
//             $record = Popularity::firstOrCreate(
//                 ['type' => 'member', 'entity_id' => $id],
//                 ['views' => 0]
//             );
//             $record->increment('views');

//         } else {
//             $param = $request->route('song');
//             $id = $param instanceof Song ? $param->getKey() : (int) $param;
//             $record = Popularity::firstOrCreate(
//                 ['type' => 'song', 'entity_id' => $id],
//                 ['views' => 0]
//             );
//             $record->increment('views');
//         }

//         return $response;
//     }
// }

