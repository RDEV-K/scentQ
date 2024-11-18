<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $prefix = trim($request->route()->getPrefix(), '/');
        $seg = explode('/', $prefix);
        $prefix = $seg[0];

        if (! $request->expectsJson()) {
            if ($prefix == 'staff') return route($prefix . '.login');
            return route('login');
        }
    }
}
