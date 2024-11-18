<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;

class RedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $domain = $request->getHost();
        $ip = $request->ip();

        if ($ip && $ip !== '127.0.0.1' && $domain) {
            $geo = GeoIP::getLocation($ip);
            if ($geo) {
                $country = $geo['iso_code'] ?? null;
                if ($country) {
                    // Constants for comparison
                    $GB = 'GB';
                    $DOMAIN_UK = 'scentq.co.uk';
                    $DOMAIN_STAGING = 'dev.scentq.com';
                    $DOMAIN_COM = 'scentq.com';

                    // Redirect logic
                    if ($country === $GB && $domain != $DOMAIN_UK) {
                        return redirect('https://scentq.co.uk' . $request->getRequestUri());
                    } elseif ($domain == $DOMAIN_UK && $country !== $GB) {
                        return redirect('https://scentq.com' . $request->getRequestUri());
                    }
                }
            }
            return $next($request);
        }
        return $next($request);
    }
}
