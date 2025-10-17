<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Profile management placeholder for administrators.
     */
    public function index(): View
    {
        return view('admin.profile.index', [
            'title' => __('Admin Profile Settings Coming Soon'),
            'message' => __('Manage your administrator account and security options from this screen once it is ready.'),
            'actionText' => __('Back to dashboard'),
        ]);
    }
}
