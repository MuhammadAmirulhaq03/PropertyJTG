<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PropertiController extends Controller
{
    /**
     * Property management placeholder for administrators.
     */
    public function index(): View
    {
        return view('admin.properti.index', [
            'title' => __('Property Management Coming Soon'),
            'message' => __('Create, update, and publish listings from this administrator workspace once available.'),
            'actionText' => __('Back to dashboard'),
        ]);
    }
}
