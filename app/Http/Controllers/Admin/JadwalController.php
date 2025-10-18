<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class JadwalController extends Controller
{
    /**
     * Scheduling placeholder for administrators.
     */
    public function index(): View
    {
        return view('admin.jadwal.index', [
            'title' => __('Schedule Management Coming Soon'),
            'message' => __('Coordinate team visits and meetings from this upcoming scheduling hub.'),
            'actionText' => __('Back to dashboard'),
        ]);
    }
}
