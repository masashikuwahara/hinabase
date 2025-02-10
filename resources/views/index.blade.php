<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップページ</title>
</head>
<body>
    <h1>トップページ</h1>

    @if (session('error'))
        <div class="alert alert-danger" style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('search') }}" method="GET">
        <input type="text" name="query" placeholder="メンバー名、楽曲名で検索">
        <button type="submit">検索</button>
    </form>

    <ul>
        <li><a href="{{ route('members.index') }}">メンバー一覧</a></li>
        <li><a href="{{ route('songs.index') }}">楽曲一覧</a></li>
    </ul>
</body>
</html>