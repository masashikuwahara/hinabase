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
        return $this->belongsToMany(Song::class, 'song_members')
        ->withPivot('is_center'); // 中間テーブルのデータを取得
        return $this->belongsToMany(Song::class, 'song_members')->withPivot('is_center'); // 中間テーブルの情報も取得
    }
}
