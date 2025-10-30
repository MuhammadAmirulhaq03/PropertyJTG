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
                    return redirect()
                        ->route('profile.edit')
                        ->with('status', __('Please change your password to continue.'))
                        ->with('must_change_password_block', true)
                        ->with('must_change_password_message', __('UPDATE YOUR FIRST PASSWORD!'))
                        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
                }
            }
        }
        $response = $next($request);

        // When forced to change password, disable caching to prevent back-forward cache showing stale pages
        if (auth()->check() && (auth()->user()->must_change_password ?? false)) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }
}
