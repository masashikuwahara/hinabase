<?php

namespace App\Http\Middleware;

use Closure;

class ForceCanonical
{
    public function handle($request, Closure $next)
    {
        $uri = $request->getRequestUri();

        if ($uri !== '/' && str_ends_with($uri, '/')) {
            return redirect(rtrim($uri, '/'), 301);
        }

        $host = $request->getHost();
        if ($request->scheme() !== 'https' || str_starts_with($host, 'www.')) {
            $target = 'https://' . ltrim(preg_replace('/^www\./', '', $host), '.') . $uri;
            return redirect($target, 301);
        }

        return $next($request);
    }
}
