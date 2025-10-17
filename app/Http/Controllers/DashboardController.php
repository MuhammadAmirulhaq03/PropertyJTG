<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\DashboardAdminController as AdminDashboard;
use App\Http\Controllers\Agen\DashboardController as AgentDashboard;
use App\Http\Controllers\Pelanggan\DashboardController as CustomerDashboard;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming dashboard request and delegate to the role-specific controller.
     */
    public function __invoke(Request $request): View
    {
        $role = $request->user()?->roleSlug() ?? config('roles.default', 'customer');

        if ($role === 'admin') {
            /** @var \Illuminate\View\View $response */
            $response = app(AdminDashboard::class)($request);

            return $response;
        }

        if ($role === 'agen') {
            /** @var \Illuminate\View\View $response */
            $response = app(AgentDashboard::class)($request);

            return $response;
        }

        /** @var \Illuminate\View\View $response */
        $response = app(CustomerDashboard::class)($request);

        return $response;
    }
}
