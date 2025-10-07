<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularityDaily extends Model
{
    protected $table = 'popularity_dailies';
    protected $fillable = ['type','entity_id','date','views'];
    protected $casts = [
        'date'  => 'date',
        'views' => 'integer',
    ];
}