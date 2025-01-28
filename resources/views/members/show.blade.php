<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->name }}のプロフィール</title>
</head>
<body>
    <h1>{{ $member->name }}のプロフィール</h1>

    <h2>参加楽曲</h2>
    @if ($member->songs->isEmpty())
        <p>このメンバーはまだ楽曲に参加していません。</p>
    @else
        <ul>
            @foreach ($member->songs as $song)
                <li>
                    {{ $song->title }}
                    @if ($song->pivot->is_center)
                        <strong>（センター）</strong>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('members.index') }}">メンバー一覧に戻る</a>
</body>
</html>
