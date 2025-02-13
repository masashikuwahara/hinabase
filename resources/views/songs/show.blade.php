<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $song->title }}</title>
    @vite('resources/css/app.css') <!-- Tailwind CSS 読み込み -->
    <style>
    .youtube-ratio iframe {
        width: 100%;
        aspect-ratio: 16 / 9;
    }
    </style>
</head>
<body class="bg-[#7cc7e8] text-gray-900">
    
    <!-- ヘッダー -->
    <header class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a href="{{ url('/') }}"><h1 class="text-2xl font-bold text-gray-800">hinabase(仮)</h1></a>
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="{{ route('members.index') }}" class="hover:text-blue-600">メンバー一覧</a></li>
                    <li><a href="{{ route('songs.index') }}" class="hover:text-blue-600">楽曲一覧</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- 楽曲詳細 -->
    <main class="container mx-auto mt-8 px-4">
        <h1 class="text-3xl font-bold">{{ $song->title }} の詳細</h1>
        
        @if ($song->members->isEmpty())
            <p class="mt-4 text-gray-700">この楽曲にはまだ参加メンバーが登録されていません。</p>
        @else
            <div class="bg-white p-6 shadow-md rounded-lg mt-4">
                <div class="flex flex-col md:flex-row">
                    <!-- ジャケット画像 -->
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/' . $song->photo) }}" alt="ジャケット" class="w-full rounded-lg">
                    </div>
                    
                    <!-- 楽曲情報 -->
                    <div class="md:w-2/3 md:pl-6">
                        <p class="text-lg mt-2 md:mt-0">リリース日: {{ \Carbon\Carbon::parse($song->release)->format('Y年m月d日') }}</p>
                        <p class="text-lg">作詞: {{ $song->lyricist }}</p>
                        <p class="text-lg">作曲: {{ $song->composer }}</p>
                        <p class="text-lg">編曲: {{ $song->arranger }}</p>
                    </div>
                </div>
            </div>
        
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
        
            <!-- ミュージックビデオ -->
            <section class="bg-white p-6 shadow-md rounded-lg mt-6">
                <h3 class="text-xl font-bold text-gray-800">ミュージックビデオ</h3>
                <div class="mt-4 aspect-w-16 aspect-h-9 youtube-ratio">
                    {!! $song->youtube !!}
                </div>
            </section>
        @endif
    </main>
    
    <!-- フッター -->
    <footer class="bg-white text-gray-700 text-center py-4 mt-8">
        <p class="text-sm">&copy; {{ date('Y') }} hinabase(仮). All rights reserved.</p>
        <div class="flex justify-center space-x-4 mt-2">
            <a href="#" class="hover:underline">Twitter</a>
            <a href="#" class="hover:underline">Instagram</a>
            <a href="#" class="hover:underline">YouTube</a>
        </div>
    </footer>
</body>
</html>
