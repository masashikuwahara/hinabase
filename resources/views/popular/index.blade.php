@extends('layouts.main')

@section('title', 'HINABASE人気ページTOP20')
@push('head_meta')
  <meta name="description" content="HINABASEで今人気のメンバー・楽曲ページTOP20。直近の閲覧データをもとにしたランキングを毎日更新。気になるプロフィールや楽曲情報にすぐアクセスできます。">
  <link rel="canonical" href="{{ url()->current() }}">

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "人気ページTOP20 | HINABASE",
    "url": "{{ url()->current() }}",
    "isPartOf": { "@type": "WebSite", "name": "HINABASE", "url": "{{ url('/') }}" },
    "mainEntity": {
      "@type": "ItemList",
      "itemListElement": [
        @php $pos = 1; @endphp
        @foreach ($cards as $c)
          {
            "@type": "ListItem",
            "position": {{ $pos++ }},
            "url": "{{ $c['url'] }}",
            "name": "{{ $c['title'] }}",
            @if(!empty($c['image']))
            "image": "{{ $c['image'] }}",
            @endif
            @if(!empty($c['updated_at']))
            "dateModified": "{{ \Illuminate\Support\Carbon::parse($c['updated_at'])->toIso8601String() }}",
            @endif
            "additionalType": "{{ $c['tag'] === 'メンバー' ? 'Person' : 'MusicRecording' }}"
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
      { "@type":"ListItem","position":1,"name":"ホーム","item":"{{ url('/') }}" },
      { "@type":"ListItem","position":2,"name":"人気ページ","item":"{{ url()->current() }}" }
    ]
  }
  </script>
@endpush


@section('content')
<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-2xl font-bold mb-4">人気ページ TOP20</h1>

  @if ($cards->isEmpty())
    <p>集計データがまだありません。</p>
  @else
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach ($cards as $card)
        <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
          <a href="{{ $card['url'] }}" class="block p-4" aria-label="{{ $card['title'] }}">
            <div class="relative">
              <img
                src="{{ $card['image'] }}"
                alt="{{ $card['title'] }}"
                class="w-32 h-32 object-cover mx-auto rounded-lg"
                loading="lazy"
                width="128" height="128"
              />
              <span class="absolute -top-2 -left-2 bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded">
                {{ $card['tag'] }}
              </span>
            </div>

            <div class="mt-2 font-semibold">
              {{ $card['title'] }}
              @if ($card['is_new'])
                <span class="text-red-600 font-bold">NEW!</span>
              @endif
            </div>

            <div class="text-xs text-gray-500 mt-1">
              最終更新：{{ \Illuminate\Support\Carbon::parse($card['updated_at'])->diffForHumans() }}
            </div>
          </a>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
