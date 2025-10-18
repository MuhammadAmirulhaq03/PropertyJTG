<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $searchHistories = $user
            ? SearchHistory::query()
                ->where('user_id', $user->id)
                ->latest('id')
                ->take(5)
                ->get()
            : collect();

        return view('pelanggan.dashboard.index', [
            'role' => $user?->roleSlug() ?? config('roles.default', 'customer'),
            'searchHistories' => $searchHistories,
        ]);
    }
}
