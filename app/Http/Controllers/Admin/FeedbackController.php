<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    /**
     * Feedback management placeholder for administrators.
     */
    public function index(): View
    {
        return view('admin.feedback.index', [
            'title' => __('Feedback Inbox Coming Soon'),
            'message' => __('We are crafting a central place to review customer feedback and action items.'),
            'actionText' => __('Back to dashboard'),
        ]);
    }
}
