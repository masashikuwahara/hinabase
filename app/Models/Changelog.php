<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Changelog extends Model
{
    protected $fillable = ['date','version','title','body','link','pinned'];

    protected $casts = [
        'date' => 'date',
        'pinned' => 'bool',
    ];

    // 最近◯日以内のものに「NEW!」バッジを付けたい時用
    public function getIsNewAttribute(): bool {
        return $this->date instanceof Carbon
            ? $this->date->gte(now()->subDays(14))
            : false;
    }

    // 固定→日付降順
    public function scopeOrdered(Builder $q): Builder {
        return $q->orderByDesc('pinned')->orderByDesc('date')->orderByDesc('id');
    }
}