<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheHeadersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $path = $request->path();

        // تحديد نوع الكاش بناءً على الامتداد
        if (preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $path)) {
            $this->setCache($response, 'public, max-age=31536000, immutable'); // سنة
        } elseif (preg_match('/\.(css|js)$/i', $path)) {
            $this->setCache($response, 'public, max-age=2592000'); // شهر
        } elseif ($request->is('api/*')) {
            $this->setCache($response, 'public, max-age=120'); // دقيقتين لـ API
        }

        return $response;
    }

    protected function setCache(Response $response, string $cacheControl): void
    {
        $response->headers->set('Cache-Control', $cacheControl);
        $response->headers->set('Pragma', 'cache');
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    }
}
