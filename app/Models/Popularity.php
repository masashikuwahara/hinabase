<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\Models\Song;

class Popularity extends Model {
    use HasFactory;

    protected $table = 'popularities';
    protected $fillable = ['type','entity_id','views'];
    protected $casts = ['views' => 'integer'];

    // 便利アクセサ：URL
    public function getUrlAttribute(): string {
        return $this->type === 'member'
            ? route('members.show', $this->entity_id)
            : route('songs.show',   $this->entity_id);
    }

    // 便利アクセサ：表示名（例として name/title を直接取る）
    public function getDisplayTitleAttribute(): string {
        if ($this->type === 'member') {
            return optional(Member::find($this->entity_id))->name ?? "メンバー #{$this->entity_id}";
        } else {
            return optional(Song::find($this->entity_id))->title ?? "楽曲 #{$this->entity_id}";
        }
    }

    // スコープ：対象タイプを絞るとき用
    public function scopeForTypes($q, array $types) {
        return $q->whereIn('type', $types);
    }
}