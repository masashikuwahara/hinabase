@extends('layouts.main')

@section('title', $member->name . ' のプロフィール')
@section('meta_description', Str::limit(strip_tags($member->bio ?? $member->name.'のプロフィール'), 120))

@push('head_meta')
  @section('og_title', $member->name . ' | SAKURAAC')
  @section('og_description', Str::limit(strip_tags($member->bio ?? ($member->name.'のプロフィール')), 120))
  @section('og_image', $member->image_url ?? asset('storage/' . $member->image) ?? 'https://kasumizaka46.com/storage/images/logo.png')
  <meta property="og:type" content="profile">
  <meta property="profile:username" content="{{ $member->name }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  @php
    $person = [
      '@context' => 'https://schema.org',
      '@type'    => 'Person',
      'name'     => $member->name,
      'alternateName' => $member->furigana,
      'url'      => url()->current(),
      'image'    => asset('storage/'.$member->image),
      'memberOf' => ['@type' => 'MusicGroup', 'name' => '櫻坂46'],
      'height'   => ['@type'=>'QuantitativeValue','value'=>(int)$member->height,'unitText'=>'cm'],
    ];
    if (!empty($member->birthday)) {
      $person['birthDate'] = \Carbon\Carbon::parse($member->birthday)->toDateString(); // ISO 8601
    }
    if (!empty($member->sns)) {
      $person['sameAs'] = [$member->sns];
    }
  @endphp
  <script type="application/ld+json">{!! json_encode($person, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "{{ $member->name }} - 櫻坂46プロフィール | 櫻坂46データベース | SAKURAAC",
    "url": "{{ url()->current() }}",
    "mainEntity": {
      "@type": "Person",
      "name": "{{ $member->name }}",
      "url": "{{ url()->current() }}"
    },
    "isPartOf": { "@type": "WebSite", "name": "SAKURAAC", "url": "{{ url('/') }}" }
  }
  </script>
@endpush

@section('og_title', $member->name . ' | SAKURAAC')
@section('og_description', Str::limit(strip_tags($member->bio ?? ($member->name.'のプロフィール')), 120))
@section('og_image', asset('storage/' . $member->image))
@push('head_meta')
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
@endpush
@section('og_image', $member->image_url ?? 'https://kasumizaka46.com/storage/images/logo.png')

@section('content')
<nav class="text-sm text-gray-600 mt-4" aria-label="パンくず">
  <ol class="flex space-x-2">
    <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
    <li>›</li>
    <li><a href="{{ route('members.index') }}" class="hover:underline">メンバー</a></li>
    <li>›</li>
    <li aria-current="page">{{ $member->name }}</li>
  </ol>
</nav>
@push('head_meta')
<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"BreadcrumbList",
 "itemListElement":[
  {"@type":"ListItem","position":1,"name":"ホーム","item":"{{ url('/') }}"},
  {"@type":"ListItem","position":2,"name":"メンバー","item":"{{ route('members.index') }}"},
  {"@type":"ListItem","position":3,"name":"{{ $member->name }}","item":"{{ url()->current() }}"}
 ]
}
</script>
@endpush
    <!-- メンバー詳細 -->
    <main class="container mx-auto mt-8 px-4">
        <h1 class="text-[2rem] text-[#c84e74] text-center mb-2 border-b-2 border-[#f19db5] pb-[0.3rem] font-bold">{{ $member->name }}</h1>
        <p class="text-xl text-center mt-2">{{ $member->furigana }}</p>
        
        <section class="flex flex-col md:flex-row items-center mt-8 bg-[#fcf3f6] p-6 shadow-md">
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/images/' . $member->image) }}" 
                     alt="{{ $member->name }} （櫻坂46）" 
                     class="w-56 h-72 object-cover shadow-md"
                     loading="lazy"
                     width="384" height="512"
                     />
            </div>

            <!-- メンバー情報 -->
            <div class="md:ml-8 mt-4 md:mt-0">
                <h2 class="text-xl font-semibold">プロフィール</h2>
                <ul class="mt-2 text-gray-800">
                    <li><strong>ニックネーム:</strong> {{ $member->nickname }}</li>
                    <li><strong>生年月日:</strong> {{ \Carbon\Carbon::parse($member->birth)->format('Y年m月d日') }}</li>
                    <li><strong>星座:</strong> {{ $member->constellation }}</li>
                    <li><strong>身長:</strong> {{ $member->height }}cm</li>
                    <li><strong>血液型:</strong> {{ $member->blood }}</li>
                    <li><strong>出身地:</strong> {{ $member->birthplace }}</li>
                    <li><strong>加入:</strong> {{ $member->grade }}</li>
                    <li><strong>参加楽曲数:</strong> {{ $songCount }}</li>
                    <li><strong>選抜回数:</strong> {{ $titlesongCount }}</li>
                    <li><strong>センター曲数:</strong> {{ $centerCount }}</li>
                    <li><strong class="mr-2">ペンライトカラー:</strong>
                        <div class="inline-flex items-center space-x-4 mt-2">
                            <div class="px-2 py-1 text-black font-bold text-shadow" style="background-color: {{ $member->color1 }}">
                                {{ $member->colorname1 }}
                            </div>
                            <div class="px-2 py-1 text-black font-bold text-shadow" style="background-color: {{ $member->color2 }}">
                                {{ $member->colorname2 }}
                            </div>
                        </div>
                    </li>
                        @if ($member->sns)
                        <li class="flex items-center">
                            <strong>SNS:</strong>&nbsp;
                            <a href="{{($member->sns) }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('/storage/photos/insta.png') }}"
                                alt="insta" 
                                class="w-7 object-cover rounded-lg shadow-md">
                            </a>
                        </li>
                        @endif
                    <li><strong>キャラクター:</strong> {{ $member->introduction }}</li>
                </ul>
            </div>
            
            <!-- レーダーチャート -->
            <!-- <div class="md:ml-8 w-72 h-72">
                <canvas id="radarChart"></canvas>
                注：ぶりっ子は㋳も含む
            </div> -->
        </section>

        {{-- 公式ブログ --}}
        @if (!empty($member->blog_url))
            <section class="flex flex-col md:flex-row items-start mt-8 bg-[#fcf3f6] p-6 shadow-md">
                <h2 class="text-xl font-bold mb-4 md:mb-0 md:mr-4 md:flex-none">公式ブログ</h2>
                <div class="mt-2 text-blue-700 font-semibold hover:text-indigo-600 md:mt-0 md:flex-1">
                    {!! $blogHtml !!}
                </div>
            </section>
        @endif

        {{-- 個人PV --}}
        @if (!empty($member->promotion_video))
            <section class="bg-[#fcf3f6] p-6 shadow-md mt-6">
                <h3 class="text-xl font-bold text-gray-800">個人PV</h3>
                <div class="mt-4 youtube-ratio">
                {!! $member->promotion_video !!}
                </div>
            </section>
        @endif
            @push('head_meta')
                @php
                $videoLd = [
                    '@context'     => 'https://schema.org',
                    '@type'        => 'VideoObject',
                    'name'         => $member->name . ' 個人PV（予告編）',
                    'description'  => $member->name . 'の個人PV（YouTube公式）',
                    'uploadDate'   => now()->toIso8601String(),
                    'thumbnailUrl' => [$member->image_url ?? asset('storage/'.$member->image)],
                    'embedUrl'     => null,
                ];
                if (preg_match('/src="([^"]+)"/', $member->promotion_video, $m)) {
                    $videoLd['embedUrl'] = $m[1];
                } else {
                    unset($videoLd['embedUrl']);
                }
                @endphp
                <script type="application/ld+json">
                {!! json_encode($videoLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
                </script>
            @endpush

        <!-- 表示切り替えボタン -->
        <div class="mt-6 space-x-4">
            <button 
                onclick="showAllSongs()" 
                class="bg-green-500 text-white py-2 px-4 hover:bg-green-700 transition">
                すべて表示
            </button>
            <button 
                onclick="showCenterOnly()" 
                class="bg-emerald-500 text-white py-2 px-4 hover:bg-emerald-700 transition">
                センター曲のみ表示
            </button>
        </div>
        
        <!-- 参加楽曲リスト -->
        <section class="mt-8">
            <h2 class="text-2xl font-semibold">参加楽曲</h2>
            @if ($member->songs->isEmpty())
                <p class="mt-2 text-gray-700">まだ参加楽曲はありません。</p>
            @else
                <ul id="songList" class="mt-4 space-y-2">
                    @foreach ($member->songs as $song)
                        <li 
                            class="bg-[#fcf3f6] p-4 shadow-md"
                            data-center="{{ $song->pivot->is_center ? '1' : '0' }}"
                        >
                            <a href="{{ route('songs.show', $song->id) }}" 
                                class="block text-lg font-semibold hover:text-blue-600">
                                {{ $song->title }}
                                @if ($song->pivot->is_center)
                                    <strong class="text-red-600">（センター）</strong>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

    </main>

    <!-- Chart.js のスクリプト -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('radarChart').getContext('2d');
            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ['歌唱力', 'ダンス', 'バラエティ', '学力', 'スポーツ', 'ぶりっ子'],
                    datasets: [{
                        label: '{{ $member->name }} のスキル',
                        data: [{{ $radar->skill->singing }}, {{ $radar->skill->dancing }}, 
                            {{ $radar->skill->variety }}, {{ $radar->skill->intelligence }}, 
                            {{ $radar->skill->sport }},{{ $radar->skill->burikko }},],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        r: {
                            suggestedMin: 0,
                            suggestedMax: 100
                            }
                        }
                    }
                });
            });
    </script> --}}
    {{-- トップに戻るボタン --}}
    <button id="back-to-top" title="トップへ戻る">TOP</button>
    <script>
    const button = document.getElementById("back-to-top");
    window.addEventListener("scroll", function () {
        if (window.pageYOffset > 300) {
            button.classList.add("show");
        } else {
            button.classList.remove("show");
        }
    });
    
    button.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    </script>

    {{-- 表示を制御 --}}
    <script>
        function showAllSongs() {
            const listItems = document.querySelectorAll('#songList li');
            listItems.forEach(item => item.style.display = 'block');
        }

        function showCenterOnly() {
            const listItems = document.querySelectorAll('#songList li');
            listItems.forEach(item => {
                if (item.dataset.center === '1') {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>

    {{-- 閲覧記録 --}}
    <script>
        (function () {
        const KEY = 'recentlyViewed';
        const list = JSON.parse(localStorage.getItem(KEY) || '[]');

        const item = {
            type: 'member',
            url: '{{ route('members.show', $member->id) }}',
            title: @json($member->name),
            image: @json(asset('storage/images/' . ltrim($member->image, '/'))),
        };

        const filtered = list.filter(x => x.url !== item.url);
        filtered.unshift(item);
        localStorage.setItem(KEY, JSON.stringify(filtered.slice(0, 12)));
        })();
    </script>

    {{-- <script>
    (() => {
    const item = {
        type: 'member',
        id: {{ $member->id }},
        title: @json($member->name),
        url: @json(route('members.show', $member->id)),
        image: @json($member->image ? asset('storage/'.$member->image) : null),
        viewedAt: Date.now()
    };

    const KEY = 'recentlyViewed';
    const MAX = 12;

    const raw = localStorage.getItem(KEY);
    let list = raw ? JSON.parse(raw) : [];

    list = list.filter(x => !(x.type === item.type && x.id === item.id));
    list.unshift(item);

    if (list.length > MAX) list = list.slice(0, MAX);

    localStorage.setItem(KEY, JSON.stringify(list));
    })();
    </script> --}}

@endsection
