<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check()) {
            $user = auth()->user();
            $now = now();
            $shouldUpdate = ! $user->last_seen_at || $user->last_seen_at->diffInSeconds($now) >= 60;

            if ($shouldUpdate) {
                // Update without touching updated_at
                \App\Models\User::where('id', $user->id)->update(['last_seen_at' => $now]);
            }
        }

        return $response;
    }
}

