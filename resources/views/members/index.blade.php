<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メンバー一覧</title>
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

    <!-- メンバー一覧 -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-semibold">メンバー一覧</h2>

        <!-- 在籍メンバー -->
        <section class="mt-6">
            <h3 class="text-xl font-bold text-gray-800">在籍メンバー</h3>
            @if ($currentMembers->isEmpty())
                <p class="mt-2 text-gray-700">在籍メンバーはいません。</p>
            @else
                @foreach ($currentMembers as $grade => $members)
                    <h4 class="text-lg font-semibold mt-4">{{ $grade }}</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                        @foreach ($members as $member)
                            <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}" 
                                         alt="{{ $member->name }}" 
                                         class="w-32 h-32 object-cover mx-auto rounded-full">
                                    <p class="mt-2 font-semibold">{{ $member->name }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </section>

        <!-- 卒業メンバー -->
        <section class="mt-8">
            <h3 class="text-xl font-bold text-gray-800">卒業メンバー</h3>
            @if ($graduatedMembers->isEmpty())
                <p class="mt-2 text-gray-700">卒業メンバーはいません。</p>
            @else
                @foreach ($graduatedMembers as $grade => $members)
                    <h4 class="text-lg font-semibold mt-4">{{ $grade }}</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-2">
                        @foreach ($members as $member)
                            <div class="bg-white shadow-md rounded-lg text-center hover:scale-105 transition-transform">
                                <a href="{{ route('members.show', $member->id) }}" class="block">
                                    <img src="{{ asset('storage/' . ($member->image ?? 'default.jpg')) }}" 
                                         alt="{{ $member->name }}" 
                                         class="w-32 h-32 object-cover mx-auto rounded-full">
                                    <p class="mt-2 font-semibold">{{ $member->name }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
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
