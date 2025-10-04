@extends('layouts.main')

@section('title', '日向坂ちゃんねるランキング | 日向坂46 | HINABASE')
@section('meta_description', '日向坂46関連のYouTubeランキング。再生数・高評価数で人気順に一覧表示。最新動画や統計グラフも掲載。')

@push('head_meta')
<link rel="canonical" href="{{ url()->current() }}">
{{-- 構造化：ItemList（再生数TOP10） --}}
<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"ItemList",
 "name":"日向坂ちゃんねるランキング（再生数）",
 "itemListElement":[
  @foreach($chart as $i => $row)
   { "@type":"ListItem", "position": {{ $i+1 }}, "name": "{{ $row['title'] }}" }@if(!$loop->last),@endif
  @endforeach
 ]
}
</script>
@endpush

@section('content')
<nav class="text-sm text-gray-600 mt-2" aria-label="パンくず">
  <ol class="flex space-x-2">
    <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
    <li>›</li>
    <li aria-current="page">日向坂ちゃんねるランキング</li>
  </ol>
</nav>

<main class="container mx-auto mt-6 px-4">
  <h1 class="text-2xl font-bold">日向坂ちゃんねるランキング</h1>
  <p class="text-sm text-gray-600 mt-1">再生数の多い順に上位を表示 ※ 毎日4回自動更新</p>

  {{-- グラフ（上位10件） --}}
  <section class="mt-6 bg-white p-4 shadow rounded">
    <h2 class="text-lg font-semibold">再生数トップ10</h2>
    <canvas id="viewsChart" class="mt-4" height="240" aria-label="再生数トップ10グラフ" role="img"></canvas>
  </section>

  {{-- ランキング表（上位50） --}}
  <section class="mt-8">
    <h2 class="text-lg font-semibold">上位一覧</h2>
    <div class="grid md:grid-cols-2 gap-4 mt-3">
      @foreach ($videosTopViews as $v)
        <article class="bg-white shadow rounded p-3 flex">
          <a href="{{ $v->watch_url }}" target="_blank" rel="noopener" class="block flex-shrink-0">
            <img src="{{ $v->thumbnail_url }}"
                 alt="{{ $v->title }}"
                 loading="lazy" width="192" height="108"
                 class="w-40 h-24 object-cover rounded">
          </a>
          <div class="ml-3 flex-1">
            <a href="{{ $v->watch_url }}" target="_blank" rel="noopener" class="font-semibold hover:underline">
              {{ $v->title }}
            </a>
            <div class="text-xs text-gray-600 mt-1">
              再生 {{ number_format($v->view_count) }}・高評価 {{ number_format($v->like_count) }}
              ・公開 {{ optional($v->published_at)->format('Y/m/d') }}
            </div>
            {{-- VideoObject 構造化（軽量版） --}}
            <script type="application/ld+json">
            {
              "@context":"https://schema.org",
              "@type":"VideoObject",
              "name":"{{ $v->title }}",
              "thumbnailUrl":"{{ $v->thumbnail_url }}",
              "uploadDate":"{{ optional($v->published_at)->toIso8601String() }}",
              "embedUrl":"{{ $v->embed_url }}",
              "url":"{{ $v->watch_url }}",
              "interactionStatistic": {
                "@type":"InteractionCounter",
                "interactionType":"https://schema.org/WatchAction",
                "userInteractionCount": {{ (int)$v->view_count }}
              }
            }
            </script>
          </div>
        </article>
      @endforeach
    </div>
  </section>

  {{-- 最新動画（時系列） --}}
  <section class="mt-10">
    <h2 class="text-lg font-semibold">最新動画</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
      @foreach ($latest as $v)
        <a href="{{ $v->watch_url }}" target="_blank" rel="noopener"
           class="bg-white shadow rounded p-2 block hover:scale-105 transition">
          <img src="{{ $v->thumbnail_url }}" alt="{{ $v->title }}"
               class="w-full aspect-video object-cover rounded" loading="lazy">
          <div class="mt-2 text-sm font-semibold line-clamp-2">{{ $v->title }}</div>
          <div class="text-xs text-gray-600">{{ optional($v->published_at)->format('Y/m/d') }}</div>
        </a>
      @endforeach
    </div>
  </section>
</main>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  (function () {
    const ctx = document.getElementById('viewsChart').getContext('2d');
    const labels = @json($chart->pluck('title'));
    const data   = @json($chart->pluck('views'));

    new Chart(ctx, {
      type: 'bar',
      data: { labels, datasets: [{ label: '再生数', data }] },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } },
        plugins: { legend: { display: false } }
      }
    });
  })();
</script>
@endsection
