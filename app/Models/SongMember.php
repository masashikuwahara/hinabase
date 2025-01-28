<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongMember extends Model
{
    use HasFactory;

    protected $fillable = ['song_id', 'member_id', 'is_center'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}