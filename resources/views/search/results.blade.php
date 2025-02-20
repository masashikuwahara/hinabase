<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
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

    <!-- 検索結果 -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-semibold">「{{ $query }}」の検索結果</h2>

        @if ($results->isEmpty())
            <p class="mt-4 text-gray-700">該当する結果が見つかりませんでした。</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-6">
                @foreach ($results as $result)
                    <div class="bg-white p-4 shadow-md rounded-lg text-center">
                        <a href="{{ $result['url'] }}" class="block">
                            <img src="{{ asset('storage/' . ($result['image'] ?? 'default.jpg')) }}" 
                                 alt="{{ $result['name'] }}" 
                                 class="w-32 h-32 object-cover mx-auto">
                            <p class="mt-2 font-semibold">{{ $result['name'] }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- 検索フォーム -->
    <div class="text-center mt-8">もう一度検索する</div>
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

    <!-- フッター -->
    <footer class="bg-[#7cc7e8] text-white text-center py-4 mt-8">
        <p class="text-sm">&copy; {{ date('Y') }} hinabase(仮). All rights reserved.</p>
        <div class="flex justify-center space-x-4 mt-2">
            <a href="#" class="hover:underline">Twitter</a>
            <a href="#" class="hover:underline">Instagram</a>
            <a href="#" class="hover:underline">YouTube</a>
        </div>
    </footer>

</body>
</html>
