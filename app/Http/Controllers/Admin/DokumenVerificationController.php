<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DokumenVerificationController extends Controller
{
    /**
     * Document verification placeholder for administrators.
     */
    public function index(): View
    {
        return view('admin.dokumen.index', [
            'title' => __('Document Verification Coming Soon'),
            'message' => __('This feature will streamline reviewing and approving customer KPR documents.'),
            'actionText' => __('Back to dashboard'),
        ]);
    }
}
