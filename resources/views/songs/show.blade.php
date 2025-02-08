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
    収録: {{ $song->is_recorded }}
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
    <div class="video">
        {!! $song->youtube !!}
    </div>
@endif
<a href="{{ route('songs.index') }}">楽曲一覧へ戻る</a>
</body>
</html>

