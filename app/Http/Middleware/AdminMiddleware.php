<?php

namespace App\Http\Middleware;

use App\Http\Exceptions\AdminUnauthorizedException;
use Closure;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guest()) {
            throw AdminUnauthorizedException::notLoggedIn();
        }

        $roles = is_array($role)
            ? $role
            : explode('|', $role);


        if (! Auth::user()->hasAnyRole($roles)) {
            throw AdminUnauthorizedException::forRoles($roles);
        }
        return $next($request);
    }
}