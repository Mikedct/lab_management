<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!session()->has('userID') || !session()->has('isUserLoggedIn')) {
            return redirect()->route('user.login')
                ->withErrors(['login' => 'Silakan login terlebih dahulu']);
        }

        return $next($request);
    }
}
