<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="email=no,telephone=no,address=no">
    <meta name="google-site-verification" content="dgN96_4bDes1EkWctdSfcV04ySWa5zsXnT_F4Aki23Y" />
    <title>
        @hasSection('title')
            @yield('title') | 日向坂46データベース | HINABASE
        @else
            日向坂46データベース | HINABASE
        @endif
    </title>
    <meta name="description" content="@yield('meta_description', '日向坂46のメンバー情報・楽曲データベースならHINABASE。プロフィール、あだ名、フォーメーション、センター回数、作曲者情報まで網羅。最新シングルや卒業情報も随時更新中。')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="{{ trim($__env->yieldContent('og_title', $__env->yieldContent('title', 'HINABASE'))) }}">
    <meta property="og:description" content="@yield('og_description', '日向坂46のメンバー情報・楽曲データベースならHINABASE。プロフィール、あだ名、フォーメーション、センター回数、作曲者情報まで網羅。最新シングルや卒業情報も随時更新中。')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="HINABASE">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:image" content="@yield('og_image', 'https://kasumizaka46.com/storage/images/logo.png')">
    <meta property="og:image:width" content="@yield('og_image_width', '1200')">
    <meta property="og:image:height" content="@yield('og_image_height', '630')">
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="{{ trim($__env->yieldContent('og_title', $__env->yieldContent('title', 'HINABASE'))) }}">
    <meta name="twitter:description" content="@yield('twitter_description', '日向坂46データベースサイト')">
    <meta name="twitter:image" content="@yield('twitter_image', 'https://kasumizaka46.com/storage/images/logo.png')">
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
    @stack('head_meta')
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