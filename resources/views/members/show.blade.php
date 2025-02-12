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
        <p>ただいま編集中です。</p>
    @else
    
    <img src="{{ asset('storage/' . $member->image) }}" alt="顔写真" width="150">
        <ul>
            <li>ニックネーム：{{ $member->nickname }}</li>
            <li>生年月日：{{ \Carbon\Carbon::parse($member->birthday)->format('Y年m月d日') }}</li>
            <li>星座：{{ $member->constellation }}</li>
            <li>身長：{{ $member->height }}㎝</li>
            <li>血液型：{{ $member->blood_type }}</li>
            <li>出身地：{{ $member->birthplace }}</li>
            <li>加入：{{ $member->grade }}</li>
            <li>ペンライトカラー：<div style="background-color: {{ $member->color1 }}; width: 150px; 
            height: 20px;">{{ $member->colorname1 }}</div></li>
            <div style="background-color: {{ $member->color2 }}; width: 150px; 
            height: 20px;">{{ $member->colorname2 }}</div>
            <li>キャラクター：{{ $member->introduction }}</li>
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
