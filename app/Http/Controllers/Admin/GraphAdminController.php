<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Graph;
use App\Models\GraphNode;
use App\Models\GraphEdge;
use App\Models\RelationType;
use App\Models\Member;

class GraphAdminController extends Controller
{
    public function index()
    {
        $graphs = Graph::query()->orderBy('sort_order')->orderByDesc('id')->get();
        return view('admin.graphs.index', compact('graphs'));
    }

    public function edit(Graph $graph)
    {
        $members = DB::table('members')
            ->orderBy('id')
            ->get(['id', 'name']);

        $graph->load([
            'nodes' => fn($q) => $q->orderBy('sort_order')->orderBy('id'),
            'edges' => fn($q) => $q->orderByDesc('id'),
            'edges.relationType',
        ]);

        $edgeCountsByNode = GraphEdge::where('graph_id', $graph->id)
            ->selectRaw('from_node_id as node_id, COUNT(*) as cnt')
            ->groupBy('from_node_id')
            ->pluck('cnt', 'node_id')
            ->toArray();

        $edgeCountsToNode = GraphEdge::where('graph_id', $graph->id)
            ->selectRaw('to_node_id as node_id, COUNT(*) as cnt')
            ->groupBy('to_node_id')
            ->pluck('cnt', 'node_id')
            ->toArray();

        // from + to を合算
        foreach ($edgeCountsToNode as $nodeId => $cnt) {
            $edgeCountsByNode[$nodeId] = ($edgeCountsByNode[$nodeId] ?? 0) + $cnt;
        }

        $relationTypes = RelationType::query()->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.graphs.edit', compact('graph', 'relationTypes', 'members', 'edgeCountsByNode'));
    }

    public function storeNode(Request $request, Graph $graph)
    {
        $data = $request->validate([
            'label' => ['required','string','max:255'],
            'member_id' => ['nullable','integer'],
            'image_url' => ['nullable','string','max:2048'],
            'size' => ['nullable','integer','min:10','max:120'],
            'sort_order' => ['nullable','integer','min:0','max:100000'],
        ]);

        $data['graph_id'] = $graph->id;
        GraphNode::create($data);

        return back()->with('status', 'ノードを追加しました');
    }

    public function updateNode(Request $request, Graph $graph, GraphNode $node)
    {
        abort_unless($node->graph_id === $graph->id, 404);

        $data = $request->validate([
            'label' => ['required','string','max:255'],
            'member_id' => ['nullable','integer'],
            'image_url' => ['nullable','string','max:2048'],
            'size' => ['nullable','integer','min:10','max:120'],
            'sort_order' => ['nullable','integer','min:0','max:100000'],
        ]);

        $node->update($data);

        return back()->with('status', 'ノードを更新しました');
    }

    public function destroyNode(Graph $graph, GraphNode $node)
    {
        abort_unless($node->graph_id === $graph->id, 404);

        $edgeCount = GraphEdge::where('graph_id', $graph->id)
            ->where(function ($q) use ($node) {
                $q->where('from_node_id', $node->id)
                ->orWhere('to_node_id', $node->id);
            })
            ->count();

        if ($edgeCount > 0) {
            return back()->withErrors([
                'node_delete' => "このノードは関連エッジが{$edgeCount}件あるため削除できません。先にエッジを削除してください。",
            ]);
        }

        $node->delete();

        return back()->with('status', 'ノードを削除しました');
    }

    public function storeEdge(Request $request, Graph $graph)
    {
        $data = $request->validate([
            'from_node_id' => ['required','integer'],
            'to_node_id' => ['required','integer','different:from_node_id'],
            'relation_type_id' => ['nullable','integer'],
            'label' => ['nullable','string','max:255'],
            'is_directed' => ['nullable','boolean'],
            'weight' => ['nullable','integer','min:1','max:10'],
        ]);

        // graph内のnodeだけ許可
        $nodeIds = $graph->nodes()->pluck('id')->all();
        abort_unless(in_array((int)$data['from_node_id'], $nodeIds, true), 422);
        abort_unless(in_array((int)$data['to_node_id'], $nodeIds, true), 422);

        $data['graph_id'] = $graph->id;
        $data['is_directed'] = (bool)($data['is_directed'] ?? false);
        $data['weight'] = (int)($data['weight'] ?? 1);

        GraphEdge::create($data);

        return back()->with('status', 'エッジを追加しました');
    }

    public function updateEdge(Request $request, Graph $graph, GraphEdge $edge)
    {
        abort_unless($edge->graph_id === $graph->id, 404);

        $data = $request->validate([
            'relation_type_id' => ['nullable','integer'],
            'label' => ['nullable','string','max:255'],
            'is_directed' => ['nullable','boolean'],
            'weight' => ['nullable','integer','min:1','max:10'],
        ]);

        $data['is_directed'] = (bool)($data['is_directed'] ?? false);
        $data['weight'] = (int)($data['weight'] ?? 1);

        $edge->update($data);

        return back()->with('status', 'エッジを更新しました');
    }

    public function destroyEdge(Graph $graph, GraphEdge $edge)
    {
        abort_unless($edge->graph_id === $graph->id, 404);
        $edge->delete();

        return back()->with('status', 'エッジを削除しました');
    }

    // admin preview data
    public function data(Graph $graph): JsonResponse
    {
        $graph->load([
            'nodes:id,graph_id,member_id,label,image_url,pos_x,pos_y,is_position_locked,size,meta,sort_order',
            'edges:id,graph_id,from_node_id,to_node_id,relation_type_id,label,is_directed,weight,meta',
            'edges.relationType:id,slug,name_ja,color',
        ]);

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
            $elements[] = [
                'data' => [
                    'id' => 'e' . $e->id,
                    'source' => 'n' . $e->from_node_id,
                    'target' => 'n' . $e->to_node_id,
                    'label' => $e->label ?? $e->relationType?->name_ja,
                    'directed' => (bool)$e->is_directed,
                    'weight' => (int)$e->weight,
                    'type' => $e->relationType?->slug,
                    'type_color' => $e->relationType?->color ?? '',
                ]
            ];
        }

        return response()->json([
            'graph' => [
                'id' => $graph->id,
                'slug' => $graph->slug,
                'title' => $graph->title,
            ],
            'elements' => $elements,
        ]);
    }

    public function savePositions(Request $request, Graph $graph)
    {
        $data = $request->validate([
            'nodes' => ['required','array'],
            'nodes.*.id' => ['required','integer'],
            'nodes.*.x' => ['required','numeric'],
            'nodes.*.y' => ['required','numeric'],
            'nodes.*.locked' => ['nullable','boolean'],
        ]);

        // graph内のnodeだけ許可
        $validIds = $graph->nodes()->pluck('id')->all();

        DB::transaction(function () use ($data, $graph, $validIds) {
            foreach ($data['nodes'] as $n) {
                $id = (int)$n['id'];
                if (!in_array($id, $validIds, true)) continue;

                GraphNode::where('graph_id', $graph->id)
                    ->where('id', $id)
                    ->update([
                        'pos_x' => $n['x'],
                        'pos_y' => $n['y'],
                        'is_position_locked' => (bool)($n['locked'] ?? false),
                    ]);
            }
        });

        return response()->json(['ok' => true]);
    }
}