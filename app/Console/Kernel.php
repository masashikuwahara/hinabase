<?php

protected function schedule(Schedule $schedule): void
{
    $schedule->command('site:generate-sitemap')->daily(); // 毎日生成
}