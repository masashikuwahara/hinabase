@extends('layouts.main')

@section('title', $song->title . ' - 日向坂46の楽曲情報')
@section('og_description', Str::limit(strip_tags($song->description ?? $song->title.'の情報'), 120))
@section('og_image', $song->photo ?? 'https://kasumizaka46.com/storage/images/logo.png')
@push('head_meta')

<meta property="og:type" content="music.song">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">

{{-- パンくず(JSON-LD) --}}
<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"BreadcrumbList",
 "itemListElement":[
  {"@type":"ListItem","position":1,"name":"ホーム","item":"{{ url('/') }}"},
  {"@type":"ListItem","position":2,"name":"楽曲一覧","item":"{{ route('songs.index') }}"},
  {"@type":"ListItem","position":3,"name":"{{ $song->title }}","item":"{{ url()->current() }}"}
 ]
}
</script>

{{-- MusicRecording(JSON-LD) --}}
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"MusicRecording",
  "name":"{{ $song->title }}",
  "url":"{{ url()->current() }}",
  "image":"{{ asset('storage/' . ($song->photo ?? 'images/logo.png')) }}",
  "byArtist":{"@type":"MusicGroup","name":"日向坂46"},
  @if(!empty($song->album_title))
  "inAlbum":{"@type":"MusicAlbum","name":"{{ $song->album_title }}"},
  @endif
  @if(!empty($song->release))
  "datePublished":"{{ \Carbon\Carbon::parse($song->release)->toDateString() }}",
  @endif
  @if(!empty($song->genre))
  "genre":"{{ $song->genre }}",
  @endif
  @if(!empty($song->duration))
  "duration":"{{ $song->duration }}",
  @endif
  @if(!empty($song->lyricist))
  "lyrics":{"@type":"CreativeWork","author":{"@type":"Person","name":"{{ $song->lyricist }}" }},
  @endif
  @if(!empty($song->composer))
  "composer":{"@type":"Person","name":"{{ $song->composer }}"},
  @endif
  @if(!empty($song->arranger))
  "recordingOf":{"@type":"MusicComposition","name":"{{ $song->title }}","musicArrangement":"{{ $song->arranger }}"},
  @endif
  @if(!empty($song->center_members))
  "creditedTo":[
    @foreach($song->center_members as $cm)
      {"@type":"Person","name":"{{ $cm }}"}@if(!$loop->last),@endif
    @endforeach
  ],
  @endif
  "publisher":{"@type":"Organization","name":"Sony Music Labels"}
}
</script>
@endpush

@section('og_title', $song->title . ' | HINABASE')
@section('og_description', Str::limit(strip_tags($song->description ?? $song->title.'の情報'), 120))
@section('og_image', $song->jacket_image_url ?? 'https://kasumizaka46.com/storage/images/logo.png')

@section('content')
<nav class="text-sm text-gray-600 mt-2" aria-label="パンくず">
    <ol class="flex space-x-2">
        <li><a href="{{ url('/') }}" class="hover:underline">ホーム</a></li>
        <li>›</li>
        <li><a href="{{ route('songs.index') }}" class="hover:underline">楽曲一覧</a></li>
        <li>›</li>
        <li aria-current="page">{{ $song->title }}</li>
    </ol>
</nav>
    <!-- 楽曲詳細 -->
    <main class="container mx-auto mt-8 px-4">
        <h1 class="text-3xl font-bold">{{ $song->title }}</h1>
        
        @if ($song->members->isEmpty())
            <p class="mt-4 text-gray-700">この楽曲にはまだ参加メンバーが登録されていません。</p>
            @else
            <section class="flex flex-col md:flex-row mt-8 bg-white p-6 shadow-md rounded-lg">
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/' . ($song->photo ?? 'default.jpg')) }}"
                    alt="{{ $song->title }}（日向坂46）"
                    class="md:w-96 md:h-96 w-auto h-auto object-cover rounded-lg shadow-md"
                    loading="lazy" width="384" height="384">
                </div>
                
                <div class="md:ml-8 mt-4 md:mt-0">
                    <h3 class="text-xl font-semibold">詳細</h3>
                    <ul class="mt-2 text-gray-800">
                        <li><strong>リリース日:</strong> {{ \Carbon\Carbon::parse($song->release)->format('Y年m月d日') }}</li>
                        <li><strong>作詞:</strong> {{ $song->lyricist }}</li>
                        <li><strong>作曲:</strong> {{ $song->composer }}</li>
                        <li><strong>編曲:</strong> {{ $song->arranger }}</li>
                    </ul>
                </div>
            </section>
        
            <!-- 収録楽曲一覧 -->
            @if (!$recordedSongs->isEmpty())
                <section class="bg-white p-6 shadow-md rounded-lg mt-6">
                    <h3 class="text-xl font-bold text-gray-800">同じ作品に収録されている楽曲</h3>
                    <ul class="mt-2">
                        @foreach ($recordedSongs as $recordedSong)
                            <li class="block text-lg font-semibold hover:text-blue-600">
                                <a href="{{ route('songs.show', $recordedSong->id) }}">{{ $recordedSong->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif
            
            <!-- 参加メンバー -->
            @if ($song->members)
            <section class="bg-white p-6 shadow-md rounded-lg mt-6">
                <h3 class="text-xl font-bold text-gray-800">参加メンバー</h3>
                <ul class="mt-2">
                    @foreach ($song->members as $member)
                        <li class="block text-lg font-semibold hover:text-blue-600">
                            <a href="{{ route('members.show', $member->id) }}">{{ $member->name }}</a>
                            @if ($member->pivot->is_center)
                                <strong class="text-red-500">（センター）</strong>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
            @endif

            <!-- 歌詞へのリンク -->
            @if ($song->lyric === "-")
            @else
            <section class="flex flex-col md:flex-row mt-8 bg-white p-6 shadow-md rounded-lg">
                <div class="md:ml-8 mt-4 md:mt-0 ">
                    <h3 class="text-xl font-semibold">歌詞はコチラ</h3>
                    <a href="{{($song->lyric) }}" target="_blank" rel="noopener noreferrer" class= "hover:text-blue-600">別リンクへ飛びます</a>
                </div>
            </section>
            @endif
            
            <!-- ミュージックビデオ -->
            @if ($song->youtube === "-")
            @else
            <section class="bg-white p-6 shadow-md rounded-lg mt-6">
                <h3 class="text-xl font-bold text-gray-800">ミュージックビデオ</h3>
                <div class="mt-4 aspect-w-16 aspect-h-9 youtube-ratio">
                    {!! $song->youtube !!}
                </div>
            </section>
            @endif
        @endif
    </main>

    {{-- 閲覧記録 --}}
    <script>
    (() => {
    const item = {
        type: 'song',
        id: {{ $song->id }},
        title: @json($song->title),
        url: @json(route('songs.show', $song->id)),
        image: @json($song->photo ? asset('storage/'.$song->photo) : null),
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
    </script>

@endsection