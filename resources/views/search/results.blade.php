<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
    @vite('resources/css/app.css') <!-- Tailwind CSS 読み込み -->
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
