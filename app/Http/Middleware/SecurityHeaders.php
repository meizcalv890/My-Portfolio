<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // CSP dimatikan saat APP_DEBUG=true (halaman error debug memakai skrip inline)
        // dan saat Vite dev server berjalan (npm run dev).
        if (! config('app.debug') && ! file_exists(public_path('hot'))) {
            $csp = [
                "default-src 'self'",
                "script-src 'self'",
                "style-src 'self' https://fonts.googleapis.com",
                "style-src-attr 'unsafe-inline'",
                "font-src 'self' https://fonts.gstatic.com",
                "img-src 'self' data: https://cdn.jsdelivr.net",
                "connect-src 'self'",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "frame-ancestors 'self'",
            ];

            if ($request->isSecure()) {
                $csp[] = 'upgrade-insecure-requests';
            }

            $response->headers->set('Content-Security-Policy', implode('; ', $csp));
        }

        return $response;
    }
}
