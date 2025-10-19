@extends('layouts.main')

@section('title', '日向坂ちゃんねる人気動画ランキング【最新】再生数・高評価数TOP | HINABASE')
@section('meta_description', '日向坂46公式YouTube「日向坂ちゃんねる」の人気動画ランキング。再生数・高評価数トップ50を毎日更新。最新動画・ショート動画・メンバー出演情報も掲載。')

@push('head_meta')
<meta property="og:type" content="website">
<meta property="og:title" content="日向坂ちゃんねる人気動画ランキング【最新】 | HINABASE">
<meta property="og:description" content="日向坂46公式YouTubeチャンネル「日向坂ちゃんねる」の人気動画を再生数順に紹介。毎日自動更新中。">
<meta property="og:image" content="{{ asset('storage/images/youtube-ranking-ogp.png') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@HINABASE_JP">
<link rel="canonical" href="{{ url()->current() }}">

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"WebPage",
 "name":"日向坂ちゃんねる人気動画ランキング | 日向坂46 | HINABASE",
 "url":"{{ url()->current() }}",
 "description":"日向坂46公式YouTube「日向坂ちゃんねる」の人気動画ランキング。再生数・高評価数トップ50を毎日自動更新。",
 "isPartOf": { "@type": "WebSite", "name": "HINABASE", "url": "{{ url('/') }}" },
 "breadcrumb": {
   "@type": "BreadcrumbList",
   "itemListElement": [
     { "@type": "ListItem", "position": 1, "name": "ホーム", "item": "{{ url('/') }}" },
     { "@type": "ListItem", "position": 2, "name": "日向坂ちゃんねるランキング", "item": "{{ url()->current() }}" }
   ]
 },
 "mainEntity": {
   "@type": "ItemList",
   "name": "日向坂ちゃんねる人気動画ランキングTOP10",
   "itemListElement": [
     @foreach($chart as $i => $row)
     { "@type": "ListItem", "position": {{ $i+1 }}, "name": "{{ $row['title'] }}" }@if(!$loop->last),@endif
     @endforeach
   ]
 }
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
  <h1 class="text-2xl font-bold">日向坂ちゃんねる人気動画ランキング【最新】</h1>
  <p class="text-sm text-gray-600 mt-1">日向坂46公式YouTubeチャンネル「日向坂ちゃんねる」の人気動画を再生数順に紹介。</p>
  <div class="flex gap-4 mb-8">
    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition scroll-btn" data-target="joui">上位一覧へ</button>
    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition scroll-btn" data-target="saishin">新着動画へ</button>
  </div>

  {{-- グラフ（上位10件） --}}
  <section class="mt-6 bg-white p-4 shadow rounded">
    <h2 class="text-lg font-semibold">再生数トップ10</h2>
    <canvas id="viewsChart" class="mt-4" height="240" aria-label="再生数トップ10グラフ" role="img"></canvas>
  </section>

  {{-- ランキング表（上位50） --}}
  <section class="mt-8">
    <h2 class="text-lg font-semibold" id="joui">上位一覧</h2>
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
            
            <script type="application/ld+json">
              {
                "@context": "https://schema.org",
                "@type": "VideoObject",
                "name": "{{ $v->title }}",
                "description": "{{ Str::limit(strip_tags($v->title), 120) }}",
                "thumbnailUrl": "{{ $v->thumbnail_url }}",
                "uploadDate": "{{ optional($v->published_at)->toIso8601String() }}",
                "embedUrl": "https://www.youtube.com/embed/{{ $v->video_id }}",
                "contentUrl": "https://www.youtube.com/watch?v={{ $v->video_id }}",
                "url": "https://www.youtube.com/watch?v={{ $v->video_id }}",
                "duration": "{{ $v->duration ?? 'PT0M0S' }}",
                "publisher": {
                  "@type": "Organization",
                  "name": "日向坂ちゃんねる",
                  "logo": {
                    "@type": "ImageObject",
                    "url": "https://kasumizaka46.com/storage/images/logo.png"
                  }
                },
                "interactionStatistic": {
                  "@type": "InteractionCounter",
                  "interactionType": "https://schema.org/WatchAction",
                  "userInteractionCount": {{ (int) $v->view_count }}
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
    <h2 class="text-lg font-semibold" id="saishin">最新動画</h2>
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
  
  <section class="mt-10 text-center">
    <p class="text-gray-700 text-sm">
      ▶ <a href="{{ route('members.index') }}" class="text-blue-600 hover:underline">日向坂46メンバー一覧</a> |
      <a href="{{ route('songs.index') }}" class="text-blue-600 hover:underline">楽曲データベース</a>
    </p>
  </section>
</main>
{{-- トップに戻るボタン --}}
<button
    id="backToTop"
    class="opacity-0 pointer-events-none fixed bottom-6 right-6 bg-orange-400 text-white p-4 rounded-full shadow-lg transition-opacity duration-500 hover:bg-orange-700 z-50"
    aria-label="トップに戻る"
>
    {{-- 上向き矢印（Heroicons） --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
    </svg>
</button>

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

<script>
    const backToTop = document.getElementById('backToTop');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTop.classList.remove('opacity-0', 'pointer-events-none');
            backToTop.classList.add('opacity-100');
        } else {
            backToTop.classList.remove('opacity-100');
            backToTop.classList.add('opacity-0', 'pointer-events-none');
        }
    });

    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>

<script>
  document.querySelectorAll('.scroll-btn').forEach(button => {
    button.addEventListener('click', () => {
      const targetId = button.dataset.target;
      const target = document.getElementById(targetId);
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });
</script>
@endsection
