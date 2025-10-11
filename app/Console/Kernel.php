<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // 6時間ごと（0,6,12,18時）
        $schedule->command('youtube:sync --max=200')->cron('0 */6 * * *');
        // $schedule->command('youtube:sync')->everyMinute();
    }
}
