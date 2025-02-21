<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hinabase(仮)</title>
    @vite('resources/css/app.css') <!-- Tailwind CSS 読み込み -->
</head>
<body class="bg-[#f0f8ff] text-gray-800">

    <!-- ヘッダー -->
    <header class="bg-[#7cc7e8] text-white py-4 px-6 flex justify-between items-center">
        <a href="{{ url('/') }}"><h1 class="text-2xl font-bold">hinabase(仮)</h1></a>
        <nav>
            <ul class="flex space-x-6 text-lg">
                <li><a href="{{ route('members.index') }}" class="hover:underline">メンバー一覧</a></li>
                <li><a href="{{ route('songs.index') }}" class="hover:underline">楽曲一覧</a></li>
            </ul>
        </nav>
    </header>

    <div class="text-center mt-8">
        <p class="text-sm">日向坂46メンバーと楽曲のシンプルなデータベースサイトです。</p>
    </div>

    <!-- 検索フォーム -->
    <div class="mt-6 text-center">
        @if (session('error'))
            <div class="text-red-600 font-semibold mb-2">{{ session('error') }}</div>
        @endif
        <form action="{{ route('search') }}" method="GET" class="inline-block bg-white p-3 rounded shadow-md">
            <input type="text" name="query" placeholder="メンバー名、楽曲名で検索" 
                class="border p-2 rounded-l-md focus:outline-none focus:ring focus:ring-[#7cc7e8]">
            <button type="submit" class="bg-[#7cc7e8] text-white p-2 rounded-r-md hover:bg-[#5aa6c4]">
                検索
            </button>
        </form>
    </div>

    <!-- メンバー一覧（グリッド表示） -->
    <section class="mt-10 px-6">
        <h2 class="text-xl font-bold mb-4">メンバー</h2>
        <div class="grid grid-cols-4 gap-4">
            @foreach ($members as $member)
                <div class="bg-white shadow-md rounded-lg p-3 text-center hover:scale-105 transition-transform">
                    <a href="{{ route('members.show', $member->id) }}">
                        <img src="{{ asset('storage/' . $member->image) }}" 
                        alt="{{ $member->name }}" 
                        class="w-20 h-20 sm:w-32 sm:h-32 object-cover rounded-full mx-auto">
                        <p class="mt-2 font-semibold">{{ $member->name }}</p>
                    </a>
                </div>
            @endforeach
            <div class="flex items-center justify-center">
                <a href="{{ route('members.index') }}" 
                    class="bg-[#7cc7e8] text-white py-2 px-4 rounded-lg hover:bg-[#5aa6c4]">
                    and more...
                </a>
            </div>
        </div>
    </section>

    <!-- 楽曲一覧（グリッド表示） -->
    <section class="mt-10 px-6">
        <h2 class="text-xl font-bold mb-4">楽曲</h2>
        <div class="grid grid-cols-4 gap-4">
            @foreach ($songs as $song)
                <div class="bg-white shadow-md rounded-lg p-3 text-center hover:scale-105 transition-transform">
                    <a href="{{ route('songs.show', $song->id) }}">
                        <img src="{{ asset('storage/' . $song->photo) }}" 
                        alt="{{ $song->title }}" 
                        class="w-20 h-20 sm:w-32 sm:h-32 object-cover rounded-lg mx-auto">
                        <p class="mt-2 font-semibold">{{ $song->title }}</p>
                    </a>
                </div>
            @endforeach
            <div class="flex items-center justify-center">
                <a href="{{ route('songs.index') }}" 
                    class="bg-[#7cc7e8] text-white py-2 px-4 rounded-lg hover:bg-[#5aa6c4]">
                    and more...
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-[#7cc7e8] text-white text-center py-4 mt-8">
        <p class="text-sm">&copy; {{ date('Y') }} hinabase(仮). All rights reserved.</p>
        <div class="flex justify-center space-x-4 mt-2">
            <a href="#" class="hover:underline">Twitter</a>
            <a href="#" class="hover:underline">Instagram</a>
            <a href="#" class="hover:underline">YouTube</a>
        </div>
    </footer>
{{-- version 1.0.0-beta --}}
</body>
</html>
