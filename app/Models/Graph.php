<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Graph extends Model
{
    protected $fillable = [
        'slug','title','description','is_published','published_at','sort_order',
    ];

    public function nodes(): HasMany
    {
        return $this->hasMany(GraphNode::class);
    }

    public function edges(): HasMany
    {
        return $this->hasMany(GraphEdge::class);
    }
}