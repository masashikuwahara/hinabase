<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->name }}のプロフィール</title>
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

    <!-- メンバー詳細 -->
    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold text-center">{{ $member->name }}</h2>
        
        <section class="flex flex-col md:flex-row items-center mt-8 bg-white p-6 shadow-md rounded-lg">
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/' . $member->image) }}" 
                     alt="{{ $member->name }}" 
                     class="w-56 h-72 object-cover rounded-lg shadow-md">
            </div>
            <div class="md:ml-8 mt-4 md:mt-0">
                <h3 class="text-xl font-semibold">プロフィール</h3>
                <ul class="mt-2 text-gray-800">
                    <li><strong>ニックネーム:</strong> {{ $member->nickname }}</li>
                    <li><strong>生年月日:</strong> {{ \Carbon\Carbon::parse($member->birthday)->format('Y年m月d日') }}</li>
                    <li><strong>星座:</strong> {{ $member->constellation }}</li>
                    <li><strong>身長:</strong> {{ $member->height }}cm</li>
                    <li><strong>血液型:</strong> {{ $member->blood_type }}</li>
                    <li><strong>出身地:</strong> {{ $member->birthplace }}</li>
                    <li><strong>加入:</strong> {{ $member->grade }}</li>
                    <li><strong>ペンライトカラー:</strong></li>
                    <div class="flex items-center space-x-4 mt-2">
                        <div class="w-26 h-6 rounded" style="background-color: {{ $member->color1 }};">{{ $member->colorname1 }}</div>
                        <div class="w-26 h-6 rounded" style="background-color: {{ $member->color2 }};">{{ $member->colorname2 }}</div>
                    </div>
                    <li><strong>キャラクター:</strong> {{ $member->introduction }}</li>
                </ul>
            </div>
        </section>
        
        <!-- 参加楽曲リスト -->
        <section class="mt-8">
            <h3 class="text-2xl font-semibold">参加楽曲</h3>
            @if ($member->songs->isEmpty())
                <p class="mt-2 text-gray-700">ただいま編集中です。</p>
            @else
                <ul class="mt-4 space-y-2">
                    @foreach ($member->songs as $song)
                        <li class="bg-white p-4 shadow-md rounded-lg">
                            <a href="{{ route('songs.show', $song->id) }}" class="block text-lg font-semibold hover:text-blue-600">
                                {{ $song->title }}
                            @if ($song->pivot->is_center)
                                <strong class="text-red-600">（センター）</strong>
                            @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
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
