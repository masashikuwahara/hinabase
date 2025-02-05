<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->name }}のプロフィール</title>
</head>
<body>
    <h1>{{ $member->name }}のプロフィール</h1>

    @if ($member->songs->isEmpty())
        <p>このメンバーはまだ楽曲に参加していません。</p>
    @else
        <ul>
            <li>{{ $member->birthday }}</li>
            <li>{{ $member->constellation }}</li>
            <li>{{ $member->blood_type }}</li>
            <li>{{ $member->birthplace }}</li>
            <li>{{ $member->grade }}</li>
            <li><div style="background-color: {{ $member->color1 }}; width: 20px; height: 20px;"></div></li>
            <li><div style="background-color: {{ $member->color2 }}; width: 20px; height: 20px;"></div></li>
            <li>{{ $member->selection }}回</li>
        </ul>
        <h2>参加楽曲</h2>
        <ul>
            @foreach ($member->songs as $song)
                <li>
                    <a href="{{ route('songs.show', $song->id) }}">{{ $song->title }}</a>
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
