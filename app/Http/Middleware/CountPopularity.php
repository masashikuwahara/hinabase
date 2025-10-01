<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Popularity;
use App\Models\Member;
use App\Models\Song;

class CountPopularity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $name = optional($request->route())->getName();
        if (!in_array($name, ['members.show','songs.show'])) return $response;

        if ($name === 'members.show') {
            $param = $request->route('member');
            $id = $param instanceof Member ? $param->getKey() : (int) $param;
            $record = Popularity::firstOrCreate(
                ['type' => 'member', 'entity_id' => $id],
                ['views' => 0]
            );
            $record->increment('views');

        } else {
            $param = $request->route('song');
            $id = $param instanceof Song ? $param->getKey() : (int) $param;
            $record = Popularity::firstOrCreate(
                ['type' => 'song', 'entity_id' => $id],
                ['views' => 0]
            );
            $record->increment('views');
        }

        return $response;
    }
}

