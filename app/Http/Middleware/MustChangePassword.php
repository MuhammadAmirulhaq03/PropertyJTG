<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustChangePassword
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->must_change_password ?? false) {
                // Allow access to password/profile routes and logout
                if (! $request->routeIs('profile.*') && ! $request->routeIs('password.*') && ! $request->routeIs('logout')) {
                    return redirect()->route('profile.edit')->with('status', __('Please change your password to continue.'));
                }
            }
        }
        return $next($request);
    }
}

