<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // 必要に応じて入れる（最小構成なら空でもOK）
    protected $middleware = [
        // ...
    ];

    protected $middlewareGroups = [
        'web' => [
            // ...
        ],
        'api' => [
            // ...
        ],
    ];

    protected $middlewareAliases = [
        'count.popularity' => \App\Http\Middleware\CountPopularity::class,
    ];

}
