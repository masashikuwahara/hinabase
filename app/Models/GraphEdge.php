<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GraphEdge extends Model
{
    protected $fillable = [
        'graph_id','from_node_id','to_node_id','relation_type_id','label','is_directed','weight','note','meta',
    ];

    protected $casts = [
        'is_directed' => 'boolean',
        'meta' => 'array',
    ];

    public function graph(): BelongsTo
    {
        return $this->belongsTo(Graph::class);
    }

    public function relationType(): BelongsTo
    {
        return $this->belongsTo(RelationType::class);
    }
}