<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProgressController extends Controller
{
    /**
     * Progress tracking placeholder for agents.
     */
    public function index(): View
    {
        return view('agen.progress.index', [
            'title' => __('Pipeline Progress Coming Soon'),
            'message' => __('A consolidated view of your clients, stages, and follow-ups will appear here soon.'),
            'actionText' => __('Back to dashboard'),
        ]);
    }
}
