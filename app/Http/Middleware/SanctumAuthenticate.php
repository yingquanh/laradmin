<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanctumAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guards)
    {
        $abilities = '';

        if ($guards === 'admin') {
            $abilities = 'AdminLogged';
        } elseif ($guards === 'web') {
            $abilities = 'UserLogged';
        }

        if (!empty($abilities) && !Auth::user()->tokenCan($abilities)) {
            throw new AuthenticationException();
        }

        return $next($request);
    }
}
