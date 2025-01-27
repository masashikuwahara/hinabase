<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>楽曲一覧</title>
</head>
<body>
    <h1>楽曲一覧</h1>
    @foreach ($songs as $song)
        <h2>{{ $song->title }}</h2>
        <ul>
            @foreach ($song->members as $member)
                <li>{{ $member->name }}</li>
            @endforeach
        </ul>
    @endforeach
</body>
</html>
