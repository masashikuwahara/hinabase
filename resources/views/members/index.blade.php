<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メンバー一覧</title>
</head>
<body>
    <h1>メンバー一覧</h1>
    <ul>
        @foreach ($members as $member)
            <li>
                <a href="{{ route('members.show', $member->id) }}">{{ $member->name }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
