<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果</title>
</head>
<body>
    <h1>「{{ $query }}」の検索結果</h1>

    @if ($results->isEmpty())
        <p>該当する結果が見つかりませんでした。</p>
    @else
        <ul>
            @foreach ($results as $result)
                <li><a href="{{ $result['url'] }}">{{ $result['name'] }}</a></li>
            @endforeach
        </ul>
    @endif

    <a href="{{ url('/') }}">トップページへ</a>
</body>
</html>