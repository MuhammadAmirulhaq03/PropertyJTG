<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HeartbeatController extends Controller
{
    public function __invoke(Request $request): Response
    {
        if ($request->user()) {
            $user = $request->user();
            $now = now();
            $shouldUpdate = ! $user->last_seen_at || $user->last_seen_at->diffInSeconds($now) >= 60;
            if ($shouldUpdate) {
                \App\Models\User::where('id', $user->id)->update(['last_seen_at' => $now]);
            }
        }

        return response()->noContent();
    }
}

