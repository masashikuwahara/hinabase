<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\YoutubeFetchService;

class SyncYoutubeRanking extends Command
{
    protected $signature = 'youtube:sync {--channel_id=} {--max=50}';
    protected $description = 'Fetch YouTube videos & stats and store/update';

    public function handle(YoutubeFetchService $svc): int
    {
        $channel = $this->option('channel_id') ?: config('services.youtube.channel_id');
        $max     = (int)$this->option('max');
        $n = $svc->syncChannel($channel, $max);
        $this->info("Synced {$n} videos from channel: {$channel}");
        return self::SUCCESS;
    }
}
