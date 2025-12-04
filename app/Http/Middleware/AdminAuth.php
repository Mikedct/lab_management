<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('adminID')) {
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}
