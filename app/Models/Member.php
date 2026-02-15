<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'furigana', 'birthday', 'constellation','height','blood_type','birthplace', 'nickname',
    'grade','color1','colorname1','color2','colorname2','promotion_video','image','graduation','introduction','sns','blog_url'];

    protected $casts = [
        'birthday' => 'date',
        ];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'song_members')
        ->withPivot('is_center'); // 中間テーブルのデータを取得
    }

    public function skill()
    {
        return $this->hasOne(Skill::class, 'member_id');
    }

    public function getIsRecentlyUpdatedAttribute()
    {
        return $this->updated_at->gt(Carbon::now()->subDays(5));
    }
}
