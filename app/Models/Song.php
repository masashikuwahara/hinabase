<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release', 'lyricist', 'composer', 
    'arranger', 'is_recorded', 'titlesong', 'youtube', 'photo'];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'song_members')
        ->withPivot('is_center');
    }

    public function getIsRecentlyUpdatedAttribute()
    {
        return $this->updated_at->gt(Carbon::now()->subDays(10));
    }
}
