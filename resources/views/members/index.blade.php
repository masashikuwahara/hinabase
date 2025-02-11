<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メンバー一覧</title>
</head>
<body>
    <h1>メンバー一覧</h1>

    <!-- 在籍メンバー -->
    <h2>在籍メンバー</h2>
    @if ($currentMembers->isEmpty())
        <p>在籍メンバーはいません。</p>
    @else
        @foreach ($currentMembers as $grade => $members)
            <h3>{{ $grade }}</h3>
            <ul>
                @foreach ($members as $member)
                    <li><a href="{{ route('members.show', $member->id) }}">{{ $member->name }}</a></li>
                @endforeach
            </ul>
        @endforeach
    @endif

    <!-- 卒業メンバー -->
    <h2>卒業メンバー</h2>
    @if ($graduatedMembers->isEmpty())
        <p>卒業メンバーはいません。</p>
    @else
        @foreach ($graduatedMembers as $grade => $members)
            <h3>{{ $grade }}</h3>
            <ul>
                @foreach ($members as $member)
                    <li><a href="{{ route('members.show', $member->id) }}">{{ $member->name }}</a></li>
                @endforeach
            </ul>
        @endforeach
    @endif

    <a href="{{ url('/') }}">トップページへ</a>
</body>
</html>
