<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $song->title }} </title>
    <style>
    @media screen and (max-width:400px) {
        .video iframe {
            position: relative;
            width: 100%;
            padding-top: 56.25%; /* 16:9のアスペクト比 */
            height: 0;
            top: 0;
            left: 0;
        }
    }
    </style>
</head>
<body>
  <h1>{{ $song->title }} の詳細</h1>

@if ($song->members->isEmpty())
    <p>この楽曲にはまだ参加メンバーが登録されていません。</p>
@else
    <img src="{{ asset('storage/' . $song->photo) }}" alt="ジャケット" width="150"><br>
    リリース日: {{ $song->release }}
    作詞: {{ $song->lyricist }}
    作曲: {{ $song->composer }}
    編曲: {{ $song->arranger }}

    <!-- 収録楽曲一覧を追加 -->
    @if (!$recordedSongs->isEmpty())
    <h2>この楽曲に収録されている楽曲</h2>
    <ul>
        @foreach ($recordedSongs as $recordedSong)
            <li>
                <a href="{{ route('songs.show', $recordedSong->id) }}">{{ $recordedSong->title }}</a>
            </li>
        @endforeach
    </ul>
    @endif
    <h2>参加メンバー</h2>
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
    <h2>ミュージックビデオ</h2>
    <div class="video">
        {!! $song->youtube !!}
    </div>
@endif

<a href="{{ route('songs.index') }}">楽曲一覧へ戻る</a>
</body>
</html>

