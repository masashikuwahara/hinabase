<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationType extends Model
{
    protected $fillable = ['slug','name_ja','name_en','color','sort_order'];
}