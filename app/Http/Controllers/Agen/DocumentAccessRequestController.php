<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\DocumentAccessRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentAccessRequestController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(config('document-access.gated', false), 404);

        $requests = DocumentAccessRequest::with(['user'])
            ->where('agent_id', $request->user()->id)
            ->where('status', DocumentAccessRequest::STATUS_REQUESTED)
            ->orderByDesc('requested_at')
            ->paginate(10);

        return view('agen.dokumen.requests.index', [
            'requests' => $requests,
        ]);
    }

    public function approve(Request $request, DocumentAccessRequest $docRequest): RedirectResponse
    {
        abort_unless(config('document-access.gated', false), 404);
        abort_unless($docRequest->agent_id === $request->user()->id, 403);

        $docRequest->forceFill([
            'status' => DocumentAccessRequest::STATUS_APPROVED,
            'decided_at' => now(),
            'decided_by' => $request->user()->id,
        ])->save();

        return back()->with('status', __('Permintaan disetujui. Pengunggahan dibuka untuk pelanggan.'));
    }

    public function reject(Request $request, DocumentAccessRequest $docRequest): RedirectResponse
    {
        abort_unless(config('document-access.gated', false), 404);
        abort_unless($docRequest->agent_id === $request->user()->id, 403);

        $docRequest->forceFill([
            'status' => DocumentAccessRequest::STATUS_REJECTED,
            'decided_at' => now(),
            'decided_by' => $request->user()->id,
        ])->save();

        return back()->with('status', __('Permintaan ditolak.'));
    }
}

