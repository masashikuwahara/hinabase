<!DOCTYPE html>
<html lang="ja">
<head>
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