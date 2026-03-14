<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Graph;

class GraphController extends Controller
{
    public function index()
    {
        
    return view('index',);
    }
    
    public function show(string $slug)
    {
        $graph = Graph::query()
            ->where('slug', $slug)
            ->firstOrFail();

        abort_unless($graph->is_published, 404);
        // 本番で「公開のみ」にするなら
        // abort_unless($graph->is_published, 404);

        return view('graphs.show', compact('graph'));
    }

    public function data(string $slug): JsonResponse
    {
        // $graph = Graph::query()
        //     ->where('slug', $slug)
        //     ->with([
        //         'nodes:id,graph_id,member_id,label,image_url,pos_x,pos_y,is_position_locked,size,meta,sort_order',
        //         'edges:id,graph_id,from_node_id,to_node_id,relation_type_id,label,is_directed,weight,meta',
        //         'edges.relationType:id,slug,name_ja,color',
        //     ])
        //     ->firstOrFail();

        // $elements = [];

        $graph = Graph::query()
            ->where('slug', $slug)
            ->firstOrFail();

        abort_unless($graph->is_published, 404);

        $graph->load([
            'nodes:id,graph_id,member_id,label,image_url,pos_x,pos_y,is_position_locked,size,meta,sort_order',
            'edges:id,graph_id,from_node_id,to_node_id,relation_type_id,label,is_directed,weight,meta',
            'edges.relationType:id,slug,name_ja,color',
        ]);

        foreach ($graph->nodes as $n) {
            $item = [
                'data' => [
                    'id' => 'n' . $n->id,
                    'label' => $n->label,
                    'member_id' => $n->member_id,
                    'image_url' => $n->image_url ?: null,
                    'size' => $n->size ?? 30,
                    'locked' => (bool) $n->is_position_locked,
                ],
            ];

            if ($n->pos_x !== null && $n->pos_y !== null) {
                $item['position'] = [
                    'x' => (float) $n->pos_x,
                    'y' => (float) $n->pos_y,
                ];
            }

            $elements[] = $item;
        }

        foreach ($graph->edges as $e) {
            $elements[] = [
                'data' => [
                    'id' => 'e' . $e->id,
                    'source' => 'n' . $e->from_node_id,
                    'target' => 'n' . $e->to_node_id,
                    'label' => $e->label ?? $e->relationType?->name_ja,
                    'directed' => (bool) $e->is_directed,
                    'weight' => (int) $e->weight,
                    'type' => $e->relationType?->slug,
                    'type_color' => $e->relationType?->color ?? '',
                    'meta' => $e->meta,
                ]
            ];
        }

        $boxes = \App\Models\GraphBox::where('graph_id', $graph->id)
            ->orderBy('z')
            ->orderBy('id')
            ->get(['id', 'label', 'color', 'x', 'y', 'w', 'h', 'z'])
            ->map(function ($b) {
                return [
                    'id' => $b->id,
                    'label' => $b->label,
                    'color' => $b->color,
                    'x' => (float) $b->x,
                    'y' => (float) $b->y,
                    'w' => (float) $b->w,
                    'h' => (float) $b->h,
                    'z' => (int) $b->z,
                ];
            })
            ->values();

        return response()->json([
            'graph' => [
                'id' => $graph->id,
                'slug' => $graph->slug,
                'title' => $graph->title,
                'description' => $graph->description,
            ],
            'elements' => $elements,
            'boxes' => $boxes,
        ]);
    }

    public function saveBoxes(Request $request, Graph $graph)
    {
        $data = $request->validate([
            'boxes' => ['required','array'],
            'boxes.*.id' => ['required','integer'],
            'boxes.*.label' => ['nullable','string','max:255'],
            'boxes.*.color' => ['nullable','string','max:32'],
            'boxes.*.x' => ['required','numeric'],
            'boxes.*.y' => ['required','numeric'],
            'boxes.*.w' => ['required','numeric','min:1'],
            'boxes.*.h' => ['required','numeric','min:1'],
            'boxes.*.z' => ['nullable','integer'],
        ]);

        $valid = \App\Models\GraphBox::where('graph_id', $graph->id)->pluck('id')->all();

        DB::transaction(function() use ($data, $graph, $valid) {
            foreach ($data['boxes'] as $b) {
                $id = (int)$b['id'];
                if (!in_array($id, $valid, true)) continue;

                \App\Models\GraphBox::where('graph_id', $graph->id)->where('id', $id)->update([
                    'label' => $b['label'] ?? null,
                    'color' => $b['color'] ?? null,
                    'x' => $b['x'],
                    'y' => $b['y'],
                    'w' => $b['w'],
                    'h' => $b['h'],
                    'z' => (int)($b['z'] ?? 0),
                ]);
            }
        });

        return response()->json(['ok' => true]);
    }
}