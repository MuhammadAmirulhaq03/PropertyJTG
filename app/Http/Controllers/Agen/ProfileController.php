<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Agent profile placeholder.
     */
    public function index(): View
    {
        return view('agen.profile.index', [
            'title' => __('Agent Profile Settings Coming Soon'),
            'message' => __('Update your workspace preferences, notification settings, and contact info here soon.'),
            'actionText' => __('Back to dashboard'),
        ]);
    }
}
