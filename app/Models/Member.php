<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'birthday', 'constellation','height','blood_type','birthplace', 'nickname',
    'grade','color1','colorname1','color2','colorname2','image','graduation','introduction','sns','blog_url'];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'song_members')
        ->withPivot('is_center'); // 中間テーブルのデータを取得
    }

    public function skill()
    {
        return $this->hasOne(Skill::class, 'member_id');
    }
}
