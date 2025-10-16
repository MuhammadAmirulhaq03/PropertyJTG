<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming dashboard request and render the view appropriate for the user's role.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $role = $user?->roleSlug() ?? config('roles.default', 'customer');

        return match ($role) {
            'admin' => view('dashboards.agent', [
                'showAdminExtras' => true,
                'role' => $role,
            ]),
            'agen' => view('dashboards.agent', [
                'showAdminExtras' => false,
                'role' => $role,
            ]),
            default => view('dashboards.customer', [
                'role' => $role,
            ]),
        };
    }
}

