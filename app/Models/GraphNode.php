<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GraphNode extends Model
{
    protected $fillable = [
        'graph_id','member_id','label','image_url','pos_x','pos_y','is_position_locked',
        'size','meta','sort_order',
    ];

    protected $casts = [
        'meta' => 'array',
        'is_position_locked' => 'boolean',
    ];

    public function graph(): BelongsTo
    {
        return $this->belongsTo(Graph::class);
    }

    public function member()
    {
        return $this->belongsTo(\App\Models\Member::class);
    }
}