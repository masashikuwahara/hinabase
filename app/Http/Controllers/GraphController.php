<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Graph;

class GraphController extends Controller
{
    public function index()
    {
        
    return view('index', compact('',));
    }
    
    public function show(string $slug)
    {
        $graph = Graph::query()
            ->where('slug', $slug)
            ->firstOrFail();

        // 本番で「公開のみ」にするなら
        // abort_unless($graph->is_published, 404);

        return view('graphs.show', compact('graph'));
    }

    public function data(string $slug): JsonResponse
    {
        $graph = Graph::query()
            ->where('slug', $slug)
            ->with([
                'nodes:id,graph_id,member_id,label,image_url,pos_x,pos_y,is_position_locked,size,meta,sort_order',
                'edges:id,graph_id,from_node_id,to_node_id,relation_type_id,label,is_directed,weight,meta',
                'edges.relationType:id,slug,name_ja,color',
            ])
            ->firstOrFail();

        // Cytoscape elements 形式に整形
        $elements = [];

        foreach ($graph->nodes as $n) {
            $item = [
                'data' => [
                    'id' => 'n' . $n->id,
                    'label' => $n->label,
                    'member_id' => $n->member_id,
                    'image_url' => $n->image_url ?: null,
                    'size' => $n->size ?? 30,
                    'locked' => (bool)$n->is_position_locked,
                ],
            ];

            if ($n->pos_x !== null && $n->pos_y !== null) {
                $item['position'] = ['x' => (float)$n->pos_x, 'y' => (float)$n->pos_y];
            }

            $elements[] = $item;
        }

        foreach ($graph->edges as $e) {
            $typeSlug = $e->relationType?->slug;
            $typeName = $e->relationType?->name_ja;
            $typeColor = $e->relationType?->color;

            $elements[] = [
                'data' => [
                    'id' => 'e' . $e->id,
                    'source' => 'n' . $e->from_node_id,
                    'target' => 'n' . $e->to_node_id,
                    'label' => $e->label ?? $typeName,
                    'directed' => (bool)$e->is_directed,
                    'weight' => (int)$e->weight,
                    'type' => $typeSlug,
                    'type_color' => $typeColor,
                    'meta' => $e->meta,
                ]
            ];
        }

        return response()->json([
            'graph' => [
                'id' => $graph->id,
                'slug' => $graph->slug,
                'title' => $graph->title,
                'description' => $graph->description,
            ],
            'elements' => $elements,
        ]);
    }
}