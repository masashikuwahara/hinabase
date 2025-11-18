@extends('layouts.main')

@section('title', '日向坂ちゃんねる【公式】人気動画ランキング・最新再生数TOP | HINABASE')
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
    <button class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition scroll-btn" data-target="joui">上位一覧へ</button>
    <button class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition scroll-btn" data-target="saishin">新着動画へ</button>
  </div>

  {{-- グラフ（上位10件） --}}
  <section class="mt-6 bg-white p-4 shadow rounded">
    <h2 class="text-lg font-semibold">日向坂ちゃんねる 再生数トップ10</h2>
    <canvas id="viewsChart" class="mt-4" height="240" aria-label="再生数トップ10グラフ" role="img"></canvas>
  </section>

  {{-- ランキング上位50 --}}
  <section class="mt-8" x-data="videoRanking()">
  <h2 class="text-lg font-semibold mb-4" id="joui">日向坂ちゃんねる 人気動画 ランキング</h2>

  <div class="flex flex-wrap gap-3 mb-6">
    <button 
      @click="sortBy = 'views'" 
      :class="sortBy === 'views' ? activeClass : baseClass">
      再生回数順
    </button>

    <button 
      @click="sortBy = 'likes'" 
      :class="sortBy === 'likes' ? activeClass : baseClass">
      高評価順
    </button>

    <button 
      @click="sortBy = 'comments'" 
      :class="sortBy === 'comments' ? activeClass : baseClass">
      コメント数順
    </button>
  </div>

  <div class="grid md:grid-cols-2 gap-4">
    <template x-for="(v, i) in sortedVideos()" :key="v.video_id">
      <article class="bg-white shadow rounded p-3 flex items-start hover:shadow-md transition-shadow duration-200">
        <a :href="`https://www.youtube.com/watch?v=${v.video_id}`"
          target="_blank"
          rel="noopener">
          <img :src="v.thumbnail_url"
              :alt="v.title"
              loading="lazy"
              width="192" height="108"
              class="w-40 h-24 object-cover rounded">
        </a>
        <div class="ml-3 flex-1">
          <a :href="`https://www.youtube.com/watch?v=${v.video_id}`"
            target="_blank"
            rel="noopener"
            class="font-semibold hover:underline block leading-tight mb-1"
            x-html="v.linked_title || v.title"></a>
          <div class="text-xs text-gray-600">
            再生 <span x-text="Number(v.view_count).toLocaleString()"></span>・
            高評価 <span x-text="Number(v.like_count).toLocaleString()"></span>・
            コメント <span x-text="Number(v.comment_count || 0).toLocaleString()"></span>・
            公開 <span x-text="formatDate(v.published_at)"></span>
          </div>
        </div>
      </article>
    </template>
  </div>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('videoRanking', () => ({
        sortBy: 'views',
        videos: @json($videosTopViews),
        baseClass: 'bg-gray-200 text-gray-700 px-4 py-1.5 rounded-full text-sm hover:bg-gray-300 transition-colors',
        activeClass: 'bg-blue-600 text-white px-4 py-1.5 rounded-full text-sm shadow-md',
        
        formatDate(dateStr) {
          if (!dateStr) return '不明'
          const d = new Date(dateStr)
          if (isNaN(d)) return '不明'
          const y = d.getFullYear()
          const m = String(d.getMonth() + 1).padStart(2, '0')
          const day = String(d.getDate()).padStart(2, '0')
          return `${y}/${m}/${day}`
        },

        sortedVideos() {
          if (!this.videos) return []
          return [...this.videos].sort((a, b) => {
            if (this.sortBy === 'likes') return b.like_count - a.like_count
            if (this.sortBy === 'comments') return (b.comment_count || 0) - (a.comment_count || 0)
            return b.view_count - a.view_count
          })
        }
      }))
    })
  </script>
</section>

@foreach ($videosTopViews as $v)
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "VideoObject",
      "name": "{{ addslashes($v->title) }}",
      "description": "{{ addslashes(Str::limit(strip_tags($v->title), 120)) }}",
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
@endforeach


  {{-- 最新動画（時系列） --}}
  <section class="mt-10">
    <h2 class="text-lg font-semibold" id="saishin">日向坂ちゃんねる 最新動画</h2>
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
{{-- トップに戻るボタン --}}
<button
    id="backToTop"
    class="opacity-0 pointer-events-none fixed bottom-6 right-6 bg-orange-400 text-white p-4 rounded-full shadow-lg transition-opacity duration-500 hover:bg-orange-700 z-50"
    aria-label="トップに戻る"
>
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
