<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BuildUnitAliasCandidates5th extends Command
{
    protected $signature = 'hinata:build-unit-alias-candidates
        {--in=private/relations_5th_edges_test7.jsonl : 入力JSONL(storage/app配下)}
        {--out=unit_alias_candidates_5th.csv : 出力CSV(storage/app配下)}
        {--min-count=2 : この回数以上のlabelのみ出力}
        {--top=200 : 上位何件まで出力するか(回数順)}';

    protected $description = 'named_relation を集計して unit_aliases 用の候補CSVを出力（label頻度 + 関連メンバー）';

    public function handle(): int
    {
        $in  = str_replace('\\', '/', (string)$this->option('in'));
        $out = str_replace('\\', '/', (string)$this->option('out'));
        $minCount = (int)$this->option('min-count');
        $top = (int)$this->option('top');

        if (!Storage::exists($in)) {
            $this->error("入力が見つかりません: " . storage_path('app/' . $in));
            return self::FAILURE;
        }

        $raw = trim(Storage::get($in));
        if ($raw === '') {
            $this->error("入力が空です: {$in}");
            return self::FAILURE;
        }

        $lines = preg_split("/\r\n|\n|\r/", $raw);

        // label => ['count'=>, 'pairs'=> [from-to => n], 'members'=> [id=>n]]
        $agg = [];

        foreach ($lines as $line) {
            $j = json_decode($line, true);
            if (!is_array($j)) continue;

            if (($j['relation_type'] ?? null) !== 'named_relation') continue;

            $label = (string)($j['label'] ?? '');
            if ($label === '') continue;

            $from = (int)($j['from_id'] ?? 0);
            $to   = (int)($j['to_id'] ?? 0);
            if (!$from || !$to) continue;

            if (!isset($agg[$label])) {
                $agg[$label] = ['count' => 0, 'pairs' => [], 'members' => []];
            }

            $agg[$label]['count']++;

            $pairKey = "{$from}-{$to}";
            $agg[$label]['pairs'][$pairKey] = ($agg[$label]['pairs'][$pairKey] ?? 0) + 1;

            $agg[$label]['members'][$from] = ($agg[$label]['members'][$from] ?? 0) + 1;
            $agg[$label]['members'][$to]   = ($agg[$label]['members'][$to] ?? 0) + 1;
        }

        // count降順
        uasort($agg, fn($a, $b) => $b['count'] <=> $a['count']);

        // CSV
        $csv = "label,count,top_members,top_pairs,suggest_is_unit,notes\n";

        $i = 0;
        foreach ($agg as $label => $data) {
            if ($data['count'] < $minCount) continue;
            $i++;
            if ($top > 0 && $i > $top) break;

            // top_members: id:score を上位5
            arsort($data['members']);
            $topMembers = array_slice($data['members'], 0, 5, true);
            $topMembersStr = implode(' | ', array_map(fn($id, $n) => "{$id}:{$n}", array_keys($topMembers), $topMembers));

            // top_pairs: from-to:n を上位5
            arsort($data['pairs']);
            $topPairs = array_slice($data['pairs'], 0, 5, true);
            $topPairsStr = implode(' | ', array_map(fn($k, $n) => "{$k}:{$n}", array_keys($topPairs), $topPairs));

            // suggest_is_unit: ざっくり推定（担当/枠/配信 などは0寄り）
            $suggest = 1;
            if (preg_match('/担当|枠|配信|番組|初選抜/u', $label)) $suggest = 0;

            $csv .= $this->csvRow([
                $label,
                $data['count'],
                $topMembersStr,
                $topPairsStr,
                $suggest,
                '',
            ]);
        }

        $csv = "\xEF\xBB\xBF" . $csv; // UTF-8 BOM
        Storage::put($out, $csv);
        $this->info("saved: storage/app/{$out}");

        return self::SUCCESS;
    }

    private function csvRow(array $cols): string
    {
        $escaped = array_map(function ($v) {
            $v = (string)$v;
            $v = str_replace('"', '""', $v);
            return "\"{$v}\"";
        }, $cols);

        return implode(',', $escaped) . "\n";
    }
}