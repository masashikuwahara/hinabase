<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $song->title }} </title>
</head>
<body>
  <h1>{{ $song->title }} の詳細</h1>

<h2>参加メンバー</h2>
@if ($song->members->isEmpty())
    <p>この楽曲にはまだ参加メンバーが登録されていません。</p>
@else
    リリース日: {{ $song->release }}
    作詞: {{ $song->lyricist }}
    作曲: {{ $song->composer }}
    編曲: {{ $song->arranger }}
    <ul>
        @foreach ($song->members as $member)
            <li>
                <a href="{{ route('members.show', $member->id) }}">{{ $member->name }}</a>
                @if ($member->pivot->is_center)
                    <strong>（センター）</strong>
                @endif
            </li>
        @endforeach
    </ul>
@endif
<a href="{{ route('songs.index') }}">楽曲一覧へ戻る</a>
</body>
</html>

