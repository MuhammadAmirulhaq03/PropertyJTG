<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CrmController extends Controller
{
    /**
     * CRM module placeholder for administrator experience.
     */
    public function index(): View
    {
        return view('admin.crm.index', [
            'title' => __('CRM Management Coming Soon'),
            'message' => __('Track leads, conversions, and team performance from this workspace once it launches.'),
            'actionText' => __('Back to dashboard'),
        ]);
    }
}
