@extends('layouts.main')

@section('title', $graph->title. ' （日向坂46）相関図 | HINABASE')
@section('meta_description', $graph->description ?? ($graph->title . 'の相関図'))

@push('head_meta')
    <meta name="robots" content="{{ $graph->is_published ? 'index,follow' : 'noindex,nofollow' }}">
    <style>
      #cy { touch-action: none; }
    </style>
@endpush

@section('content')
<div class="mx-auto max-w-6xl px-4 py-6">
    <header class="mb-4">
        <h1 class="text-2xl font-bold">{{ $graph->title }}</h1>
        @if($graph->description)
            <p class="mt-2 text-sm text-gray-600 leading-6">{{ $graph->description }}</p>
        @endif
    </header>
    {{-- 操作バー --}}
    <div class="mb-3 flex flex-wrap items-center gap-2">
        <button id="btn-fit" class="px-3 py-2 rounded bg-gray-900 text-white text-sm">全体表示</button>
        <button id="btn-relayout" class="px-3 py-2 rounded bg-gray-200 text-sm">レイアウト再計算</button>

        <div class="ml-auto flex items-center gap-2">
            <label class="text-sm text-gray-700">エッジラベル</label>
            <select id="edge-label-mode" class="border rounded px-2 py-2 text-sm">
              <option value="always" selected>常に表示</option>
              <option value="hover">ホバー時のみ</option>
              <option value="never">非表示</option>
            </select>
        </div>
    </div>

    {{-- 図エリア --}}
    <div class="rounded-lg border bg-white overflow-hidden">
        <div id="cy" class="w-full" style="height: 70vh; min-height: 320px;"></div>
    </div>

    {{-- モバイル向け：タップしたノード情報 --}}
    <div class="mt-4 rounded-lg border bg-white p-4">
        <div class="text-sm text-gray-500">選択中</div>
        <div id="info" class="mt-1 text-base font-semibold">メンバーをタップしてください</div>
        <div id="info-sub" class="mt-1 text-sm text-gray-700"></div>

        <a id="info-link"
          href="#"
          class="mt-3 inline-flex items-center gap-2 px-3 py-2 rounded bg-gray-900 text-white text-sm hidden">
          メンバー詳細へ
        </a>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Cytoscape CDN（プロトタイプ用。後でViteに移行OK） --}}
    <script src="https://unpkg.com/cytoscape@3.27.0/dist/cytoscape.min.js"></script>

    {{-- もしレイアウトでcose-bilkent等を使いたい場合は追加読み込みも可能 --}}
    {{-- <script src="https://unpkg.com/cytoscape-cose-bilkent/cytoscape-cose-bilkent.js"></script> --}}

    <script>
      const memberBaseUrl = @json(url('/members')); // HINABASEの members 詳細が /members/{id} 想定
      const infoLinkEl = document.getElementById('info-link');
        (function () {
            const dataUrl = @json(route('graphs.data', ['slug' => $graph->slug]));

            const infoEl = document.getElementById('info');
            const infoSubEl = document.getElementById('info-sub');

            function setInfo(title, sub = '', memberId = null) {
              infoEl.textContent = title || '';
              infoSubEl.textContent = sub || '';

              if (memberId) {
                infoLinkEl.href = `${memberBaseUrl}/${memberId}`;
                infoLinkEl.classList.remove('hidden');
              } else {
                infoLinkEl.href = '#';
                infoLinkEl.classList.add('hidden');
              }
            }

            function safeLabel(ele) {
                return ele?.data?.('label') ?? ele?.data?.('id') ?? '';
            }

            function buildCy(elements) {
                // position: null を含む要素があるので除去（Cytoscapeはposition無しでOK）
                const normalized = elements.map(e => {
                    const copy = JSON.parse(JSON.stringify(e));
                    if (!copy.position) delete copy.position;
                    return copy;
                });
                
                const hasPositions = normalized.some(e => e.position && e.position.x != null && e.position.y != null);
                const cy = cytoscape({
                    container: document.getElementById('cy'),
                    elements: normalized,
                    // layout: {
                    //     name: 'cose',
                    //     animate: true,
                    //     animationDuration: 400,
                    //     fit: true,
                    //     padding: 30,
                    // },
                    layout: hasPositions
                    ? { name: 'preset', fit: true, padding: 30 }
                    : { name: 'cose', animate: true, animationDuration: 400, fit: true, padding: 30 },
                    style: [
                        {
                        selector: 'node',
                        style: {
                            'label': 'data(label)',
                            'text-wrap': 'wrap',
                            'text-max-width': 90,
                            'font-size': 10,
                            'text-valign': 'center',
                            'text-halign': 'center',
                            'color': '#ffffff',
                            'width': 'mapData(size, 10, 120, 28, 60)',
                            'height': 'mapData(size, 10, 120, 28, 60)',
                            'border-width': 2,
                            'border-color': '#ffffff',
                        }
                        },
                        {
                        selector: 'node[!image_url]',
                        style: {
                            'background-color': '#111827',
                        }
                        },
                        {
                        selector: 'node[image_url]',
                        style: {
                            'background-image': 'data(image_url)',
                            'background-fit': 'cover',
                            'background-clip': 'node',
                            'background-opacity': 1,

                            // 画像の上に名前を出したくないなら
                            'label': '',
                        }
                        },
                        {
                            selector: 'node:selected',
                            style: {
                                'border-width': 4,
                                'border-color': '#111827',
                                'background-color': '#374151',
                            }
                        },
                        {
                            selector: 'edge',
                            style: {
                                'curve-style': 'bezier',
                                'width': 'mapData(weight, 1, 10, 1, 6)',
                                'line-color': 'data(type_color)',
                                'target-arrow-color': 'data(type_color)',
                                'target-arrow-shape': 'triangle',
                                'arrow-scale': 0.9,
                                'label': 'data(label)',
                                'font-size': 9,
                                'text-rotation': 'autorotate',
                                'text-margin-y': -6,
                                'color': '#111827',
                                'text-background-color': '#ffffff',
                                'text-background-opacity': 0.8,
                                'text-background-padding': 2,
                            }
                        },
                        // directed=false のとき矢印を消す
                        {
                            selector: 'edge[directed = "false"]',
                            style: {
                                'target-arrow-shape': 'none'
                            }
                        },
                        // type_color が無い場合のフォールバック
                        {
                            selector: 'edge[type_color = ""]',
                            style: {
                                'line-color': '#9ca3af',
                                'target-arrow-color': '#9ca3af'
                            }
                        }
                    ],
                });

                // ノードをタップしたら情報表示
                cy.on('tap', 'node', function (evt) {
                  const n = evt.target;
                if (evt.target === cy) setInfo('ノードをタップしてください', '', null);
                  const memberId = n.data('member_id');
                  setInfo(
                    safeLabel(n),
                    memberId ? `member_id: ${memberId}` : '自由ノード',
                    memberId
                  );
                });

                // エッジタップで関係表示
                cy.on('tap', 'edge', function (evt) {
                    const e = evt.target;
                    const source = cy.getElementById(e.data('source'));
                    const target = cy.getElementById(e.data('target'));
                    const label = e.data('label') || '';
                    setInfo(`${safeLabel(source)} → ${safeLabel(target)}`, label ? `関係: ${label}` : '');
                });

                // 背景タップで選択解除
                cy.on('tap', function (evt) {
                    if (evt.target === cy) setInfo('ノードをタップしてください', '');
                });

                // 位置ロックされたノードがあるならロック（将来用）
                cy.nodes().forEach(n => {
                    if (n.data('locked')) n.lock();
                });

                return cy;
            }

            function applyEdgeLabelMode(cy, mode) {
                const show = (mode === 'always');
                const hover = (mode === 'hover');

                cy.style()
                    .selector('edge')
                    .style('label', show ? 'data(label)' : '')
                    .update();

                if (hover) {
                    cy.on('mouseover', 'edge', function (evt) {
                        evt.target.style('label', evt.target.data('label') || '');
                    });
                    cy.on('mouseout', 'edge', function (evt) {
                        evt.target.style('label', '');
                    });
                }
            }

            async function init() {
                try {
                    const res = await fetch(dataUrl, { headers: { 'Accept': 'application/json' }});
                    if (!res.ok) throw new Error('failed to fetch graph data');
                    const json = await res.json();

                    // type_color が null の場合に備えて空文字へ
                    const elements = (json.elements || []).map(el => {
                        if (el?.data && (el.data.type_color === null || el.data.type_color === undefined)) {
                            el.data.type_color = '';
                        }
                        if (el?.data && (el.data.size === null || el.data.size === undefined)) {
                            // sizeを入れていないノードでも mapData が効くように
                            el.data.size = 30;
                        }
                        return el;
                    });

                    const cy = buildCy(elements);

                    // ボタン類
                    document.getElementById('btn-fit').addEventListener('click', () => {
                        cy.fit(undefined, 30);
                    });

                    document.getElementById('btn-relayout').addEventListener('click', () => {
                        cy.layout({
                            name: 'cose',
                            animate: true,
                            animationDuration: 400,
                            fit: true,
                            padding: 30,
                        }).run();
                    });

                    const select = document.getElementById('edge-label-mode');
                    applyEdgeLabelMode(cy, select.value);
                    select.addEventListener('change', () => applyEdgeLabelMode(cy, select.value));

                } catch (e) {
                    console.error(e);
                    setInfo('読み込みに失敗しました', 'コンソールを確認してください');
                }
            }

            init();
        })();
    </script>
@endpush