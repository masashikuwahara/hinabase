<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>楽曲一覧</title>
</head>
<body>
    <h1>楽曲一覧</h1>
    <h2>表題曲</h2>
    @if ($singles->isEmpty())
    <p>表題曲はまだありません。</p>
    @else
        <ul>
            @foreach ($singles as $song)
                <li>
                    <a href="{{ route('songs.show', $song->id) }}">{{ $song->title }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h2>c/w、その他</h2>
    @if ($others->isEmpty())
    <p>表題曲はまだありません。</p>
    @else
        <ul>
            @foreach ($others as $song)
                <li>
                    <a href="{{ route('songs.show', $song->id) }}">{{ $song->title }}</a>
                </li>
            @endforeach
        </ul>
    @endif
    <a href="{{ url('/') }}">トップページへ</a>
</body>
</html>

