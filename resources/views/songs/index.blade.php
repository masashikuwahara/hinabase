<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>楽曲一覧</title>
</head>
<body>
    <h1>楽曲一覧</h1>
    <ul>
        @foreach ($songs as $song)
            <li>
                <a href="{{ route('songs.show', $song->id) }}">{{ $song->title }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>

