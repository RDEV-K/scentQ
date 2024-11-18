<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class StaffHasCapMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array $caps
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next, ...$caps)
    {
        $v = count($caps) > 1 ? $caps : $caps[0];
        if (auth()->guard('staff')->user()->hasCap($v)) return $next($request);
        throw new AuthorizationException('This action is unauthorized.');
    }
}
