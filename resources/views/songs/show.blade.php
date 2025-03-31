@extends('layouts.main')

@section('title', $song->title )

@section('content')
    <!-- 楽曲詳細 -->
    <main class="container mx-auto mt-8 px-4">
        <h1 class="text-3xl font-bold">{{ $song->title }}</h1>
        
        @if ($song->members === "")
            <p class="mt-4 text-gray-700">この楽曲にはまだ参加メンバーが登録されていません。</p>
            @else
            <section class="flex flex-col md:flex-row mt-8 bg-white p-6 shadow-md rounded-lg">
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/' . $song->photo) }}" 
                        alt="{{ $song->title }}" 
                        class="md:w-96 md:h-96 w-auto h-auto object-cover rounded-lg shadow-md ">
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
                    <h3 class="text-xl font-bold text-gray-800">この楽曲に収録されている楽曲</h3>
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
            @if ($song->lyric)
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
@endsection