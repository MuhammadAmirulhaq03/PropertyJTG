<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('agen.dashboard.index', [
            'showAdminExtras' => false,
            'role' => $request->user()?->roleSlug() ?? 'agen',
        ]);
    }
}
