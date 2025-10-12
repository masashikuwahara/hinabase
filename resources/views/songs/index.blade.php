@extends('layouts.main')

@section('title', '櫻坂46楽曲一覧')
@section('meta_description', '櫻坂46の楽曲一覧。表題曲・カップリング曲を網羅。発売日・センター・参加メンバー・作詞作曲情報の個別ページへリンク。最新更新も随時反映。')

@push('head_meta')
@php
  $hasPage = (int)request('page') > 1;
@endphp
<link rel="canonical" href="{{ $hasPage ? request()->fullUrl() : url()->current() }}">

{{-- CollectionPage + ItemList(JSON-LD) --}}
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"CollectionPage",
  "name":"櫻坂46楽曲一覧 | HINABASE",
  "url":"{{ request()->fullUrl() }}",
  "isPartOf":{"@type":"WebSite","name":"HINABASE","url":"{{ url('/') }}"},
  "mainEntity":{
    "@type":"ItemList",
    "itemListElement":[
      @php
        // 表題曲＋その他を1つのリストに（順位はページ内の見え方優先）
        $list = collect($singles)->concat($others);
        $pos = 1;
      @endphp
      @foreach($list as $song)
        {
          "@type":"ListItem",
          "position": {{ $pos++ }},
          "url": "{{ route('songs.show', $song->id) }}",
          "name": "{{ $song->title }}"
        }@if(!$loop->last),@endif
      @endforeach
    ]
  }
}
</script>

<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"BreadcrumbList",
 "itemListElement":[
  {"@type":"ListItem","position":1,"name":"ホーム","item":"{{ url('/') }}"},
  {"@type":"ListItem","position":2,"name":"楽曲一覧","item":"{{ request()->fullUrl() }}"}
 ]
}
</script>
@endpush

@section('content')
  <nav class="text-sm text-gray-600 mt-2" aria-label="パンくず">
    <ol class="flex space-x-2">
      <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
      <li>›</li>
      <li aria-current="page">楽曲一覧</li>
    </ol>
  </nav>

  <main class="container mx-auto mt-8 px-4">
    <h1 class="text-2xl font-semibold">楽曲一覧</h1>

    {{-- 表題曲 --}}
    <section class="mt-6">
      <h2 class="text-xl font-bold text-gray-800">表題曲</h2>
      @if ($singles->isEmpty())
        <p class="mt-2 text-gray-700">表題曲はまだありません。</p>
      @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
          @foreach ($singles as $song)
            <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
              <a href="{{ route('songs.show', $song->id) }}" class="block">
                <img src="{{ asset('storage/photos/' . ($song->photo ?? 'default.jpg')) }}"
                     alt="{{ $song->title }}（櫻坂46）"
                     class="w-20 h-20 sm:w-32 sm:h-32 object-cover mx-auto"
                     loading="lazy" width="128" height="128">
                <p class="mt-2 font-semibold">{{ $song->title }}</p>
                <span class="mt-2 font-semibold">
                  @if ($song->is_recently_updated)
                    <span class="text-red-600 font-bold">NEW!</span>
                  @endif
                </span>
              </a>
            </div>
          @endforeach
        </div>
      @endif
    </section>

    {{-- アルバム曲--}}
    <section class="mt-8">
      <h2 class="text-xl font-bold text-gray-800">アルバム収録曲</h2>
      @if ($albums->isEmpty())
        <p class="mt-2 text-gray-700">アルバム収録曲はまだありません。</p>
      @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
          @foreach ($albums as $album)
            <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
              <a href="{{ route('songs.show', $album->id) }}" class="block">
                <img src="{{ asset('storage/photos/' . ($album->photo ?? 'default.jpg')) }}"
                     alt="{{ $album->title }}（櫻坂46）"
                     class="w-20 h-20 sm:w-32 sm:h-32 object-cover mx-auto"
                     loading="lazy" width="128" height="128">
                <p class="mt-2 font-semibold">{{ $album->title }}</p>
                <span class="mt-2 font-semibold">
                  @if ($album->is_recently_updated)
                    <span class="text-red-600 font-bold">NEW!</span>
                  @endif
                </span>
              </a>
            </div>
          @endforeach
        </div>
      @endif
    </section>

    {{-- c/w・その他 --}}
    <section class="mt-8">
      <h2 class="text-xl font-bold text-gray-800">c/w・その他</h2>
      @if ($others->isEmpty())
        <p class="mt-2 text-gray-700">c/wやその他の楽曲はまだありません。</p>
      @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
          @foreach ($others as $song)
            <div class="bg-white shadow-md p-3 text-center hover:scale-105 transition-transform">
              <a href="{{ route('songs.show', $song->id) }}" class="block">
                <img src="{{ asset('storage/photos/' . ($song->photo ?? 'default.jpg')) }}"
                     alt="{{ $song->title }}（櫻坂46）"
                     class="w-20 h-20 sm:w-32 sm:h-32 object-cover mx-auto"
                     loading="lazy" width="128" height="128">
                <p class="mt-2 font-semibold">{{ $song->title }}</p>
                <span class="mt-2 font-semibold">
                  @if ($song->is_recently_updated)
                    <span class="text-red-600 font-bold">NEW!</span>
                  @endif
                </span>
              </a>
            </div>
          @endforeach
        </div>
      @endif
    </section>
  </main>
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
@endsection
