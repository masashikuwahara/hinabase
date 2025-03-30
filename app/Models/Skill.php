<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class skill extends Model
{
    protected $fillable = ['member_id', 'singing', 'dancing', 'variety', 'intelligence', 'sport', 'burikko'];
    public function member()
{
    return $this->belongsTo(Member::class, 'member_id');
}
}
