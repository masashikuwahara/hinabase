<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="keyword" content="日向坂46,ヒナタザカ46,ひなたざか46,hinatazaka46,潮紗理菜,加藤史帆,齊藤京子,佐々木久美,
    佐々木美玲,高瀬愛奈,高本彩花,東村芽依,金村美玖,河田陽菜,小坂菜緒,富田鈴花,丹生明里,濱岸ひより,松田好花,上村ひなの,髙橋未来虹,
    森本茉莉,山口陽世,石塚瑶季,小西夏菜実,清水理央,正源司陽子,竹内希来里,平尾帆夏,平岡海月,藤嶌果歩,宮地すみれ,山下葉留花,渡辺莉奈" />
    {{-- <meta name="description" content="日向坂46のシンプルなデータベースサイトです。メンバー情報、楽曲情報を載せています。"> --}}
    <meta name="description" content="@yield('meta_description', '日向坂46のシンプルなデータベースサイトです。メンバー情報、楽曲情報を載せています。')">
    <meta name="format-detection" content="email=no,telephone=no,address=no">
    <meta name="google-site-verification" content="dgN96_4bDes1EkWctdSfcV04ySWa5zsXnT_F4Aki23Y" />
    <link rel="canonical" href="{{ url()->current() }}">
    {{-- <meta property="og:title" content="HINABASE">
    <meta property="og:description" content="日向坂46のシンプルなデータベースサイトです。メンバー情報、楽曲情報を載せています。">
    <meta property="og:image" content="https://kasumizaka46.com/storage/images/logo.png">
    <meta property="og:url" content="https://kasumizaka46.com"> 
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="HINABASE"> --}}
    <meta property="og:title" content="@yield('og_title', trim((string)View::getSections()['title'] ?? 'HINABASE'))">
    <meta property="og:description" content="@yield('og_description', '日向坂46のシンプルなデータベースサイトです。メンバー情報、楽曲情報を載せています。')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="HINABASE">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:image" content="@yield('og_image', 'https://kasumizaka46.com/storage/images/logo.png')">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('twitter_title', trim((string)View::getSections()['title'] ?? 'HINABASE'))">
    <meta name="twitter:description" content="@yield('twitter_description', '日向坂46データベースサイト')">
    <meta name="twitter:image" content="@yield('twitter_image', 'https://kasumizaka46.com/storage/images/logo.png')">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>@yield('title')</title> --}}
    <title>
        @hasSection('title')
            @yield('title') | HINABASE - 日向坂46データベースサイト
        @else
            HINABASE - 日向坂46データベースサイト
        @endif
    </title>
    @vite('resources/css/app.css')
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "https://kasumizaka46.com/",
        "name": "HINABASE",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://kasumizaka46.com/search?q={query}",
            "query-input": "required name=query"
        }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
    .youtube-ratio iframe {
        width: 100%;
        aspect-ratio: 16 / 9;
    }
    .text-shadow {
        text-shadow:
        -1px -1px 0 #fff,
         1px -1px 0 #fff,
        -1px  1px 0 #fff,
         1px  1px 0 #fff;
    }
    </style>
</head>
<body class="bg-[#f0f8ff] text-gray-800">

    @include('partials.header')

    <main class="container mx-auto">
        @yield('content')
    </main>

    @include('partials.footer')
@stack('scripts')
</body>
</html>