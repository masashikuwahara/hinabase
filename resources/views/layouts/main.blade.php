<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="description" content="日向坂46のシンプルなデータベースサイトです。メンバー情報、楽曲情報を載せています。">
    <meta name="format-detection" content="email=no,telephone=no,address=no">
    <meta property="og:title" content="HINABASE">
    <meta property="og:description" content="日向坂46のシンプルなデータベースサイトです。メンバー情報、楽曲情報を載せています。">
    <meta property="og:image" content="https://kasumizaka46.com/storage/images/logo.png">
    <meta property="og:url" content="https://kasumizaka46.com"> 
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="HINABASE">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <style>
        .youtube-ratio iframe {
            width: 100%;
            aspect-ratio: 16 / 9;
        }
    </style>
</head>
<body class="bg-[#f0f8ff] text-gray-800">

    @include('partials.header')

    <main class="container mx-auto">
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
<!-- version1.0.0-beta -->