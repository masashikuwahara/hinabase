<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '管理ページ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <nav>
            <ul>
                {{-- <li><a href="{{ route('admin.members.create') }}">メンバー追加</a></li>
                <li><a href="{{ route('admin.songs.create') }}">楽曲追加</a></li> --}}
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
