<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="description" content="@yield('meta_description', '櫻坂46のメンバー情報・楽曲データベースならHINABASE。プロフィール、あだ名、フォーメーション、センター回数、作曲者情報まで網羅。最新シングルや卒業情報も随時更新中。')">
    <meta name="format-detection" content="email=no,telephone=no,address=no">
    <meta name="google-site-verification" content="dgN96_4bDes1EkWctdSfcV04ySWa5zsXnT_F4Aki23Y" />
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ trim($__env->yieldContent('og_title', $__env->yieldContent('title', 'HINABASE'))) }}">
    <meta property="og:description" content="@yield('og_description', '櫻坂46のメンバー情報・楽曲データベースならHINABASE。プロフィール、あだ名、フォーメーション、センター回数、作曲者情報まで網羅。最新シングルや卒業情報も随時更新中。')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="HINABASE">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:image" content="@yield('og_image', 'https://kasumizaka46.com/storage/images/logo.png')">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="{{ trim($__env->yieldContent('og_title', $__env->yieldContent('title', 'HINABASE'))) }}">
    <meta name="twitter:description" content="@yield('twitter_description', '櫻坂46データベースサイト')">
    <meta name="twitter:image" content="@yield('twitter_image', 'https://kasumizaka46.com/storage/images/logo.png')">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @hasSection('title')
            @yield('title') | 櫻坂46データベース | HINABASE
        @else
            櫻坂46データベース | HINABASE
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
    /* .youtube-ratio iframe {
        width: 100%;
        aspect-ratio: 16 / 9;
    } */
    .text-shadow {
        text-shadow:
        -1px -1px 0 #fff,
         1px -1px 0 #fff,
        -1px  1px 0 #fff,
         1px  1px 0 #fff;
    }
    #back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 100;
        background-color: #007bff;
        color: #fff;
        border: none;
        width: 50px;
        height: 50px;
        background-color: #f87171; 
        clip-path: polygon(0% 100%, 100% 100%, 100% 0%);
        padding: 25px 25px 5PX 25PX;
        font-size: 10px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: opacity 0.8s ease, transform 0.8s ease, visibility 0s linear 0.8s;
        z-index: 1000;
    }

    #back-to-top:hover {
        background-color: #0056b3;
    }

    #back-to-top.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        transition: opacity 0.8s ease, transform 0.8s ease, visibility 0s;
    }
    </style>
    @stack('head_meta')
</head>
<body class="bg-[#fff0f5] text-gray-800">

    @include('partials.header')

    <main class="container mx-auto">
        @yield('content')
    </main>

    @include('partials.footer')
@stack('scripts')
</body>
</html>