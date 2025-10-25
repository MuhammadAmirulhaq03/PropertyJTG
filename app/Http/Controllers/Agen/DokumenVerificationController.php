<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agen\DocumentReviewRequest;
use App\Models\DocumentUpload;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DokumenVerificationController extends Controller
{
    private const STORAGE_DISK = 'local';

    public function index(Request $request): View
    {
        $requirements = config('document-requirements', []);
        $documentTypes = collect($requirements)
            ->mapWithKeys(fn ($meta, $key) => [$key => $meta['label'] ?? Str::headline(str_replace('_', ' ', $key))])
            ->all();

        $filters = [
            'status' => $request->string('status')->toString(),
            'document_type' => $request->string('document_type')->toString(),
            'search' => trim((string) $request->input('search', '')),
        ];

        $userIds = null;
        if ($filters['search'] !== '') {
            $userIds = User::query()
                ->where(function ($query) use ($filters) {
                    $term = $filters['search'];
                    $query->where('name', 'like', '%' . $term . '%')
                        ->orWhere('email', 'like', '%' . $term . '%');
                })
                ->pluck('id');
        }

        $documents = DocumentUpload::query()
            ->with('user')
            ->when($userIds, fn ($query) => $query->whereIn('user_id', $userIds))
            ->get()
            ->groupBy('user_id')
            ->filter(fn (Collection $docs) => $docs->first()?->user !== null)
            ->map(function (Collection $docs) use ($filters) {
                $user = $docs->first()->user;

                if ($filters['document_type'] !== '' && $docs->where('document_type', $filters['document_type'])->isEmpty()) {
                    return null;
                }

                $overall = $this->resolveCustomerStatus($docs);

                return collect([
                    'user' => $user,
                    'latest_update' => $docs->max('updated_at'),
                    'total_documents' => $docs->count(),
                    'submitted_count' => $docs->where('status', DocumentUpload::STATUS_SUBMITTED)->count(),
                    'approved_count' => $docs->where('status', DocumentUpload::STATUS_APPROVED)->count(),
                    'revision_count' => $docs->whereIn('status', [
                        DocumentUpload::STATUS_REVISION,
                        DocumentUpload::STATUS_REJECTED,
                    ])->count(),
                    'overall_status' => $overall['status'],
                    'overall_label' => $overall['label'],
                    'overall_badge' => $overall['badge'],
                ]);
            })
            ->filter();

        if ($filters['status'] !== '') {
            $documents = $documents->filter(fn ($summary) => $summary['overall_status'] === $filters['status']);
        }

        $documents = $documents
            ->sortByDesc('latest_update')
            ->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $total = $documents->count();
        $items = $documents->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $statusLabels = $this->customerStatusLabels();
        $statusMetrics = $documents->groupBy('overall_status')->map->count();

        return view('agen.dokumen.index', [
            'customers' => $paginator,
            'documentTypes' => $documentTypes,
            'statusLabels' => $statusLabels,
            'statusMetrics' => $statusMetrics,
            'filters' => $filters,
        ]);
    }

    public function download(DocumentUpload $documentUpload)
    {
        $disk = Storage::disk(self::STORAGE_DISK);

        if (! $disk->exists($documentUpload->file_path)) {
            return redirect()
                ->route('agent.documents.index')
                ->withErrors(['document' => __('File not found. Please contact the customer to re-upload.')]);
        }

        return $disk->download($documentUpload->file_path, $documentUpload->original_name);
    }

    public function update(DocumentReviewRequest $request, DocumentUpload $documentUpload): RedirectResponse
    {
        $documentUpload->update([
            'status' => $request->input('status'),
            'review_notes' => $request->input('review_notes'),
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        if ($request->input('redirect_to') === 'customer') {
            $query = array_filter([
                'status' => $request->input('filter_status'),
                'document_type' => $request->input('filter_document_type'),
                'search' => $request->input('filter_search'),
            ], fn ($value) => filled($value));

            return redirect()
                ->route('agent.documents.show', array_merge(['user' => $documentUpload->user_id], $query))
                ->with('status', __('Document status updated.'));
        }

        $redirectQuery = array_filter([
            'status' => $request->input('filter_status'),
            'document_type' => $request->input('filter_document_type'),
            'search' => $request->input('filter_search'),
        ], fn ($value) => filled($value));

        return redirect()
            ->route('agent.documents.index', $redirectQuery)
            ->with('status', __('Document status updated.'));
    }

    public function show(Request $request, User $user): View
    {
        $documents = DocumentUpload::query()
            ->where('user_id', $user->id)
            ->orderBy('document_type')
            ->orderByDesc('updated_at')
            ->get();

        $requirements = config('document-requirements', []);

        $filters = [
            'status' => $request->string('status')->toString(),
            'document_type' => $request->string('document_type')->toString(),
            'search' => trim((string) $request->input('search', '')),
        ];

        return view('agen.dokumen.show', [
            'user' => $user,
            'documents' => $documents,
            'requirements' => $requirements,
            'statusLabels' => DocumentUpload::statusLabels(),
            'filters' => $filters,
        ]);
    }

    private function resolveCustomerStatus(Collection $documents): array
    {
        $hasAttention = $documents->contains(fn (DocumentUpload $doc) => in_array($doc->status, [
            DocumentUpload::STATUS_REJECTED,
            DocumentUpload::STATUS_REVISION,
        ], true));

        $allApproved = $documents->isNotEmpty() && $documents->every(fn (DocumentUpload $doc) => $doc->status === DocumentUpload::STATUS_APPROVED);

        $hasSubmitted = $documents->contains(fn (DocumentUpload $doc) => $doc->status === DocumentUpload::STATUS_SUBMITTED);

        if ($hasAttention) {
            return [
                'status' => 'needs_attention',
                'label' => __('Needs attention'),
                'badge' => 'bg-red-100 text-red-700',
            ];
        }

        if ($allApproved) {
            return [
                'status' => 'approved',
                'label' => __('All approved'),
                'badge' => 'bg-emerald-100 text-emerald-700',
            ];
        }

        if ($hasSubmitted || $documents->isNotEmpty()) {
            return [
                'status' => 'in_progress',
                'label' => __('In progress'),
                'badge' => 'bg-amber-100 text-amber-700',
            ];
        }

        return [
            'status' => 'not_started',
            'label' => __('Not started'),
            'badge' => 'bg-slate-100 text-slate-600',
        ];
    }

    private function customerStatusLabels(): array
    {
        return [
            'needs_attention' => __('Needs attention'),
            'in_progress' => __('In progress'),
            'approved' => __('All approved'),
            'not_started' => __('Not started'),
        ];
    }
}
