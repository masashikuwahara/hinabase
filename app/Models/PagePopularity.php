<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagePopularity extends Model {
  use HasFactory;
    
    protected $table = 'popularities';
    protected $fillable = ['type','entity_id','views'];
    protected $casts = ['views' => 'integer',];
        
    public static function bump(string $type, int $id): void
    {
        static::query()
            ->where(['type' => $type, 'entity_id' => $id])
            ->increment('views', 1, ['updated_at' => now()]);
    }
}