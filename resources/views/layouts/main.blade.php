<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="keyword" content="日向坂46,ヒナタザカ46,ひなたざか46,hinatazaka46,潮紗理菜,加藤史帆,齊藤京子,佐々木久美,
    佐々木美玲,高瀬愛奈,高本彩花,東村芽依,金村美玖,河田陽菜,小坂菜緒,富田鈴花,丹生明里,濱岸ひより,松田好花,上村ひなの,髙橋未来虹,
    森本茉莉,山口陽世,石塚瑶季,小西夏菜実,清水理央,正源司陽子,竹内希来里,平尾帆夏,平岡海月,藤嶌果歩,宮地すみれ,山下葉留花,渡辺莉奈" />
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
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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