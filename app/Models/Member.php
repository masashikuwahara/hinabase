<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'furigana', 'birthday', 'constellation','height','blood_type','birthplace', 'nickname',
    'grade','final_membership_date','color1','colorname1','color2','colorname2','promotion_video','image','graduation','introduction','sns','blog_url'];

    protected $casts = [
        'birthday' => 'date',
        'final_membership_date' => 'date',
        ];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'song_members')
        ->withPivot('is_center');
    }

    public function skill()
    {
        return $this->hasOne(Skill::class, 'member_id');
    }

    public function getIsRecentlyUpdatedAttribute()
    {
        return $this->updated_at->gt(Carbon::now()->subDays(5));
    }

    public function scopeOrderByGrade($query)
    {
        return $query->orderByRaw("
            CASE grade
                WHEN '一期生' THEN 1
                WHEN '二期生' THEN 2
                WHEN '三期生' THEN 3
                WHEN '四期生' THEN 4
                WHEN '五期生' THEN 5
                ELSE 99
            END
        ");
    }
}
