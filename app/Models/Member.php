<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'birthday', 'position'];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'song_members');
    }
}
