<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DocumentAccessRequest;
use App\Models\User;
use App\Notifications\DocumentAccessRequestedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentAccessRequestController extends Controller
{
    public function create(Request $request): View
    {
        abort_unless(config('document-access.gated', false), 404);
        // Soft handling: if there is already an active request, redirect with a gentle pop-up
        $active = DocumentAccessRequest::query()
            ->with('agent')
            ->where('user_id', $request->user()->id)
            ->whereIn('status', [DocumentAccessRequest::STATUS_REQUESTED, DocumentAccessRequest::STATUS_APPROVED])
            ->latest('requested_at')
            ->first();

        if ($active) {
            $agentName = optional($active->agent)->display_name ?? optional($active->agent)->name;
            return redirect()->route('documents.index')
                ->with('already_sent', __('Anda sudah mengirim Permintaan Izin Dokumen kepada: :name', ['name' => $agentName]));
        }

        $agents = User::query()->where('role', 'agen')->orderBy('name')->get(['id','name','email']);

        return view('pelanggan.dokumen.request-access', [
            'agents' => $agents,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(config('document-access.gated', false), 404);

        $validated = $request->validate([
            'agent_id' => ['required','integer','exists:users,id'],
            'note' => ['nullable','string','max:500'],
        ]);

        // Enforce single active request per customer (requested or approved)
        $existingActive = DocumentAccessRequest::query()
            ->with('agent')
            ->where('user_id', $request->user()->id)
            ->whereIn('status', [DocumentAccessRequest::STATUS_REQUESTED, DocumentAccessRequest::STATUS_APPROVED])
            ->latest('requested_at')
            ->first();

        if ($existingActive) {
            $agentName = optional($existingActive->agent)->display_name ?? optional($existingActive->agent)->name;
            return redirect()->route('documents.index')
                ->with('already_sent', __('Anda sudah mengirim Permintaan Izin Dokumen kepada: :name', ['name' => $agentName]))
                ->withErrors(['document' => __('Anda sudah memiliki permintaan aktif yang ditujukan kepada: :name.', ['name' => $agentName])]);
        }

        $agent = User::query()->whereKey((int) $validated['agent_id'])->firstOrFail();

        $docRequest = DocumentAccessRequest::create([
            'user_id' => $request->user()->id,
            'agent_id' => (int) $validated['agent_id'],
            'status' => DocumentAccessRequest::STATUS_REQUESTED,
            'note' => $validated['note'] ?? null,
            'requested_at' => now(),
        ]);

        // Notify the selected agent (database notification)
        $agent->notify(new DocumentAccessRequestedNotification($request->user(), $docRequest));

        return redirect()->route('documents.index')->with('status', __('Permintaan peninjauan dokumen dikirim ke :name.', ['name' => $agent->display_name ?? $agent->name]));
    }
}
