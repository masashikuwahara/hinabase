@extends('layouts.main')

@php
  // URL
  $pageUrl = url()->current();

  // タイトル/説明（descriptionが空のときも自然な文に）
  $seoTitle = $graph->title . '（日向坂46）相関図 | HINABASE';
  $seoDesc = $graph->description
      ? $graph->description
      : ($graph->title . 'の相関図。メンバー同士の関係性・ユニット・関連グループを可視化。');

  // index制御
  $robots = $graph->is_published ? 'index,follow' : 'noindex,nofollow';

  // OGP画像（graph側に用意が無ければサイトのデフォルトへ）
  // 例：/public/ogp/default-graph.png を置く想定
  $ogImage = $graph->og_image_url ?? asset('ogp/default-graph.png');

  // indexは後でやるとのことなので、ひとまず /graphs を一覧想定
  $graphsIndexUrl = url('/graphs');
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDesc)

@push('head_meta')
  {{-- robots --}}
  <meta name="robots" content="{{ $robots }}">

  {{-- canonical --}}
  <link rel="canonical" href="{{ $pageUrl }}">

  {{-- OGP --}}
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="HINABASE">
  <meta property="og:title" content="{{ $seoTitle }}">
  <meta property="og:description" content="{{ $seoDesc }}">
  <meta property="og:url" content="{{ $pageUrl }}">
  <meta property="og:image" content="{{ $ogImage }}">

  {{-- Twitter --}}
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $seoTitle }}">
  <meta name="twitter:description" content="{{ $seoDesc }}">
  <meta name="twitter:image" content="{{ $ogImage }}">

  {{-- 構造化データ（公開時のみ推奨：noindexページに出しても害は少ないが、運用的に分けると綺麗） --}}
  @if($graph->is_published)
    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@graph":[
        {
          "@type":"WebSite",
          "@id":"{{ url('/') }}#website",
          "name":"HINABASE",
          "url":"{{ url('/') }}"
        },
        {
          "@type":"WebPage",
          "@id":"{{ $pageUrl }}#webpage",
          "url":"{{ $pageUrl }}",
          "name":"{{ $seoTitle }}",
          "description":"{{ $seoDesc }}",
          "isPartOf":{"@id":"{{ url('/') }}#website"},
          "inLanguage":"ja",
          "about":[
            {"@type":"MusicGroup","name":"日向坂46"}
          ]
        },
        {
          "@type":"BreadcrumbList",
          "@id":"{{ $pageUrl }}#breadcrumb",
          "itemListElement":[
            {"@type":"ListItem","position":1,"name":"ホーム","item":"{{ url('/') }}"},
            {"@type":"ListItem","position":2,"name":"相関図","item":"{{ $graphsIndexUrl }}"},
            {"@type":"ListItem","position":3,"name":"{{ $graph->title }}","item":"{{ $pageUrl }}"}
          ]
        }
      ]
    }
    </script>
  @endif

  {{-- Cytoscape領域の操作 --}}
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
    @if($graph->is_published)
    <div class="mt-3 text-xs text-gray-500 leading-5">
        <p>このページは日向坂46の相関図です。ノード（メンバー/ユニット）をタップすると詳細を表示します。</p>
        <noscript>
        <p class="mt-2 text-red-600">※ 相関図の表示にはJavaScriptが必要です。</p>
        </noscript>
    </div>
    @endif
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

    {{-- モバイル向け：タップしたノード情報 --}}
    <div class="mb-4 rounded-lg border bg-white p-4">
        <div class="text-sm text-gray-500">選択中</div>
        <div id="info" class="mt-1 text-base font-semibold">メンバーをタップしてください</div>
        <div id="info-sub" class="mt-1 text-sm text-gray-700"></div>

        <a id="info-link"
          href="#"
          class="mt-3 inline-flex items-center gap-2 px-3 py-2 rounded bg-gray-900 text-white text-sm hidden">
          メンバー詳細へ
        </a>
    </div>

    {{-- 図エリア --}}
    <div class="rounded-lg border bg-white overflow-hidden">
        <div id="cy-wrap" class="relative" style="height: 70vh; min-height: 320px;">
            <div id="cy" class="absolute inset-0"></div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    {{-- Cytoscape CDN（プロトタイプ用。後でViteに移行OK） --}}
    <script defer src="https://unpkg.com/cytoscape@3.27.0/dist/cytoscape.min.js"></script>

    {{-- もしレイアウトでcose-bilkent等を使いたい場合は追加読み込みも可能 --}}
    {{-- <script src="https://unpkg.com/cytoscape-cose-bilkent/cytoscape-cose-bilkent.js"></script> --}}

    <script>
    const memberBaseUrl = @json(url('/members'));
    const infoLinkEl = document.getElementById('info-link');

    (function () {
        const dataUrl = @json(route('graphs.data', ['slug' => $graph->slug]));

        const infoEl = document.getElementById('info');
        const infoSubEl = document.getElementById('info-sub');
        const cyWrap = document.getElementById('cy-wrap');
        const cyContainer = document.getElementById('cy');

        let boxes = [];
        let boxEls = new Map();

        function setInfo(title, sub = '', memberSlug = null) {
            infoEl.textContent = title || '';
            infoSubEl.textContent = sub || '';

            if (memberSlug) {
                infoLinkEl.href = `${memberBaseUrl}/${memberSlug}`;
                infoLinkEl.classList.remove('hidden');
            } else {
                infoLinkEl.href = '#';
                infoLinkEl.classList.add('hidden');
            }
        }

        function safeLabel(ele) {
            return ele?.data?.('label') ?? ele?.data?.('id') ?? '';
        }

        function ensureOverlay() {
            let overlay = cyWrap.querySelector('.box-overlay');

            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'box-overlay';
                overlay.style.position = 'absolute';
                overlay.style.inset = '0';
                overlay.style.pointerEvents = 'none';
                overlay.style.zIndex = '20';
                cyWrap.appendChild(overlay);
            }

            return overlay;
        }

        function modelToRendered(cy, x, y) {
            const pan = cy.pan();
            const zoom = cy.zoom();
            return {
                x: x * zoom + pan.x,
                y: y * zoom + pan.y,
            };
        }

        function updateBoxElement(cy, b) {
            console.log('updateBoxElement', b.id, b.x, b.y, b.w, b.h);
            const el = boxEls.get(b.id);
            if (!el) return;

            const leftTop = modelToRendered(cy, b.x - b.w / 2, b.y - b.h / 2);
            const rightBottom = modelToRendered(cy, b.x + b.w / 2, b.y + b.h / 2);

            const left = Math.min(leftTop.x, rightBottom.x);
            const top = Math.min(leftTop.y, rightBottom.y);
            const width = Math.abs(rightBottom.x - leftTop.x);
            const height = Math.abs(rightBottom.y - leftTop.y);
            console.log('rendered box rect', b.id, left, top, width, height);

            el.style.left = left + 'px';
            el.style.top = top + 'px';
            el.style.width = width + 'px';
            el.style.height = height + 'px';

            const label = el.querySelector('.box-label');
            if (label) label.textContent = b.label || '';
        }

        function renderBoxes(cy) {
            const overlay = ensureOverlay();

            boxes.forEach(b => {
                let el = boxEls.get(b.id);

                if (!el) {
                    el = document.createElement('div');
                    el.dataset.id = b.id;
                    el.style.position = 'absolute';
                    el.style.border = `3px solid ${b.color || '#ef4444'}`;
                    el.style.borderRadius = '12px';
                    el.style.background = 'rgba(239,68,68,0.06)';
                    el.style.boxSizing = 'border-box';
                    el.style.pointerEvents = 'none';
                    el.style.zIndex = String(10 + (b.z || 0));

                    const label = document.createElement('div');
                    label.className = 'box-label';
                    label.style.position = 'absolute';
                    label.style.top = '-12px';
                    label.style.left = '10px';
                    label.style.padding = '2px 8px';
                    label.style.fontSize = '12px';
                    label.style.background = 'white';
                    label.style.border = `1px solid ${b.color || '#ef4444'}`;
                    label.style.borderRadius = '999px';
                    label.textContent = b.label || '';
                    el.appendChild(label);

                    overlay.appendChild(el);
                    boxEls.set(b.id, el);
                }

                updateBoxElement(cy, b);
            });
        }

        function bindBoxRedraw(cy) {
            cy.on('pan zoom render', () => renderBoxes(cy));
            window.addEventListener('resize', () => renderBoxes(cy));
        }

        function buildCy(elements) {
            const normalized = elements.map(e => {
                const copy = JSON.parse(JSON.stringify(e));
                if (!copy.position) delete copy.position;
                return copy;
            });

            const hasPositions = normalized.some(e => e.position && e.position.x != null && e.position.y != null);

            const cy = cytoscape({
                container: cyContainer,
                elements: normalized,
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
                    {
                        selector: 'edge[directed = "false"]',
                        style: {
                            'target-arrow-shape': 'none'
                        }
                    },
                    {
                        selector: 'edge[type_color = ""]',
                        style: {
                            'line-color': '#9ca3af',
                            'target-arrow-color': '#9ca3af'
                        }
                    }
                ],
            });

            cy.on('tap', 'node', function (evt) {
                const n = evt.target;
                const memberId = n.data('member_id');
                const memberSlug = n.data('member_slug');

                setInfo(
                    safeLabel(n),
                    memberId ? `member_id: ${memberId}` : '自由ノード',
                    memberSlug || null
                );
            });

            cy.on('tap', 'edge', function (evt) {
                const e = evt.target;
                const source = cy.getElementById(e.data('source'));
                const target = cy.getElementById(e.data('target'));
                const label = e.data('label') || '';
                setInfo(`${safeLabel(source)} → ${safeLabel(target)}`, label ? `関係: ${label}` : '');
            });

            cy.nodes().forEach(n => {
                if (n.data('locked')) n.lock();
            });

            bindBoxRedraw(cy);
            renderBoxes(cy);

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
                const res = await fetch(dataUrl, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) throw new Error('failed to fetch graph data');
                const json = await res.json();
                console.log('json.boxes', json.boxes);
                console.log('json.elements', json.elements);
                console.log('cyWrap', cyWrap);

                const elements = (json.elements || []).map(el => {
                    if (el?.data && (el.data.type_color === null || el.data.type_color === undefined)) {
                        el.data.type_color = '';
                    }
                    if (el?.data && (el.data.size === null || el.data.size === undefined)) {
                        el.data.size = 30;
                    }
                    return el;
                });

                boxes = (json.boxes || []).map(b => ({
                    ...b,
                    x: parseFloat(b.x),
                    y: parseFloat(b.y),
                    w: parseFloat(b.w),
                    h: parseFloat(b.h),
                    z: parseInt(b.z ?? 0, 10),
                }));
                console.log('parsed boxes', boxes);

                const cy = buildCy(elements);

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
                setInfo('読み込みに失敗しました', 'もう一度読み込んでください');
            }
        }

        init();
    })();
    </script>
@endpush