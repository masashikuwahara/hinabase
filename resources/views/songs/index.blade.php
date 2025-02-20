<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>楽曲一覧</title>
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

    <!-- 楽曲一覧 -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-semibold">楽曲一覧</h2>

        <!-- 表題曲 -->
        <section class="mt-6">
            <h3 class="text-xl font-bold text-gray-800">表題曲</h3>
            @if ($singles->isEmpty())
                <p class="mt-2 text-gray-700">表題曲はまだありません。</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @foreach ($singles as $song)
                    <div class="bg-white shadow-md rounded-lg p-3 text-center hover:scale-105 transition-transform">
                        <a href="{{ route('songs.show', $song->id) }}" class="block">
                            <img src="{{ asset('storage/' . ($song->photo ?? 'default.jpg')) }}" 
                                alt="{{ $song->title }}" 
                                class="w-20 h-20 sm:w-32 sm:h-32 object-cover rounded-lg mx-auto"">
                            <p class="mt-2 font-semibold">{{ $song->title }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- c/w、その他 -->
        <section class="mt-8">
            <h3 class="text-xl font-bold text-gray-800">c/w、その他</h3>
            @if ($others->isEmpty())
                <p class="mt-2 text-gray-700">c/wやその他の楽曲はまだありません。</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @foreach ($others as $song)
                        <div class="bg-white shadow-md rounded-lg p-3 text-center hover:scale-105 transition-transform">
                            <a href="{{ route('songs.show', $song->id) }}" class="block">
                                <img src="{{ asset('storage/' . ($song->photo ?? 'default.jpg')) }}" 
                                    alt="{{ $song->title }}" 
                                    class="w-20 h-20 sm:w-32 sm:h-32 object-cover rounded-lg mx-auto"">
                                <p class="mt-2 font-semibold">{{ $song->title }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>

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
