<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GraphBox extends Model
{
    protected $fillable = [
        'graph_id',
        'label',
        'color',
        'x',
        'y',
        'w',
        'h',
        'z',
    ];

    public function graph(): BelongsTo
    {
        return $this->belongsTo(Graph::class);
    }
}