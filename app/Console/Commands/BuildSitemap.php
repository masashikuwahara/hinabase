<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class BuildSitemap extends Command
{
    protected $signature = 'sitemap:build';
    protected $description = 'Build sitemap.xml into public/';

    public function handle(): int
    {
        // ここに列挙したいURLを積む（必要に応じて随時追加）
        $urls = [];

        // 固定ページ
        $urls[] = ['loc' => url('/'), 'lastmod' => now()->toAtomString()];
        $urls[] = ['loc' => url('/members'), 'lastmod' => now()->toAtomString()];
        $urls[] = ['loc' => url('/songs'), 'lastmod' => now()->toAtomString()];
        $urls[] = ['loc' => url('/others'), 'lastmod' => now()->toAtomString()];
        $urls[] = ['loc' => url('/popular'), 'lastmod' => now()->toAtomString()];
        $urls[] = ['loc' => url('/youtube/ranking'), 'lastmod' => now()->toAtomString()];

        foreach (\App\Models\Member::cursor() as $m) {
            $urls[] = [
                'loc'     => route('members.show', $m->id),
                'lastmod' => optional($m->updated_at)->toAtomString()
            ];
        }
        foreach (\App\Models\Song::cursor() as $s) {
            $urls[] = [
                'loc'     => route('songs.show', $s->id),
                'lastmod' => optional($s->updated_at)->toAtomString()
            ];
        }

        // XML生成
        $xml = $this->toXml($urls);

        // 書き出し
        $path = public_path('sitemap.xml');
        file_put_contents($path, $xml);

        $this->info("sitemap.xml written: {$path} (".number_format(strlen($xml))." bytes)");
        return self::SUCCESS;
    }

    private function toXml(array $urls): string
    {
        $doc  = [];
        $doc[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $doc[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $u) {
            $loc = htmlspecialchars($u['loc'], ENT_QUOTES | ENT_XML1, 'UTF-8');
            $lastmod = $u['lastmod'] ?? null;
            $doc[] = '  <url>';
            $doc[] = "    <loc>{$loc}</loc>";
            if ($lastmod) {
                $doc[] = "    <lastmod>{$lastmod}</lastmod>";
            }
            $doc[] = '  </url>';
        }
        $doc[] = '</urlset>';
        return implode("\n", $doc)."\n";
    }
}
