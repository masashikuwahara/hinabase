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
                生年月日
                <li>{{ $member->birthday }}</li>
                星座
                <li>{{ $member->constellation }}</li>
                血液型
                <li>{{ $member->blood_type }}</li>
                出身地
                <li>{{ $member->birthplace }}</li>
                何期生？
                <li>{{ $member->grade }}</li>
                ペンライトカラー
                <li><div style="background-color: {{ $member->color1 }}; width: 20px; height: 20px;"></div></li>
                <li><div style="background-color: {{ $member->color2 }}; width: 20px; height: 20px;"></div></li>
                選抜回数
                <li>{{ $member->selection }}回</li>
                参加楽曲
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
