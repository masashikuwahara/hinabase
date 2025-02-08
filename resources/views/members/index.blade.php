<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メンバー一覧</title>
</head>
<body>
    <h1>メンバー一覧</h1>
    <h2>在籍メンバー</h2>
    @if ($currentMembers->isEmpty())
        <p>在籍メンバーはいません。</p>
    @else
        <ul>
            @foreach ($currentMembers as $member)
                <li>
                    <a href="{{ route('members.show', $member->id) }}">{{ $member->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h2>卒業メンバー</h2>
    @if ($graduatedMembers->isEmpty())
        <p>卒業メンバーはいません。</p>
    @else
        <ul>
            @foreach ($graduatedMembers as $member)
                <li><a href="{{ route('members.show', $member->id) }}">{{ $member->name }}</a></li>
            @endforeach
        </ul>
    @endif
    <a href="{{ url('/') }}">トップページへ</a>
</body>
</html>
