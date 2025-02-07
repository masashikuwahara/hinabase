<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release', 'lyricist', 'composer', 
    'arranger', 'titlesong', 'youtube', 'photo'];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'song_members')->withPivot('is_center');
    }
}
