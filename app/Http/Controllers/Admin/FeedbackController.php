<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Properti;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FeedbackController extends Controller
{
    /**
     * Display the feedback index with filters, sorting, and summary.
     */
    public function index(Request $request): View
    {
        $filters = $this->filtersFromRequest($request);

        $baseQuery = $this->filteredQuery($filters);

        $feedbackItems = (clone $baseQuery)
            ->paginate(12)
            ->withQueryString();

        $filteredCount = (clone $baseQuery)->count();

        $stats = [
            'total' => Feedback::count(),
            'avg_rating' => round((float) Feedback::avg('rating'), 1),
            'positive' => Feedback::where('rating', '>=', 4)->count(),
            'neutral' => Feedback::where('rating', 3)->count(),
            'negative' => Feedback::where('rating', '<=', 2)->count(),
            'filtered' => $filteredCount,
        ];

        $properties = Properti::orderBy('nama')
            ->get(['id', 'nama']);

        $moods = $this->moodOptions();

        return view('admin.feedback.index', [
            'feedbackItems' => $feedbackItems,
            'filters' => $filters,
            'stats' => $stats,
            'properties' => $properties,
            'moods' => $moods,
        ]);
    }

    /**
     * Export filtered feedback as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $filters = $this->filtersFromRequest($request);
        $query = $this->filteredQuery($filters);
        $moods = $this->moodOptions();

        $filename = 'feedback-export-'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($query, $moods) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                __('Tanggal'),
                __('Nama Pelanggan'),
                __('Email'),
                __('Properti'),
                __('Rating'),
                __('Mood'),
                __('Komentar'),
            ]);

            $query->chunk(200, function ($rows) use ($handle, $moods) {
                foreach ($rows as $feedback) {
                    $customerName = optional($feedback->customer?->user)->name ?? __('Tidak diketahui');
                    $customerEmail = optional($feedback->customer?->user)->email ?? 'N/A';
                    $propertyName = optional($feedback->properti)->nama ?? 'N/A';
                    $comment = trim($feedback->message ?? '') ?: trim($feedback->komentar ?? '');
                    $feedbackDate = $feedback->tanggal ? Carbon::parse($feedback->tanggal)->format('Y-m-d') : 'N/A';

                    fputcsv($handle, [
                        $feedbackDate,
                        $customerName,
                        $customerEmail,
                        $propertyName,
                        $feedback->rating,
                        $moods[$feedback->mood] ?? 'N/A',
                        $comment,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Remove a feedback entry.
     */
    public function destroy(Feedback $feedback): RedirectResponse
    {
        $feedback->delete();

        return back()->with('success', __('Feedback dihapus.'));
    }

    /**
     * Build a filtered query for feedback entries.
     */
    protected function filteredQuery(array $filters): Builder
    {
        $query = Feedback::query()
            ->with([
                'customer.user',
                'properti',
            ]);

        if ($filters['search']) {
            $query->where(function ($inner) use ($filters) {
                $inner->where('komentar', 'like', '%'.$filters['search'].'%')
                    ->orWhere('message', 'like', '%'.$filters['search'].'%');
            });
        }

        if ($filters['property_id']) {
            $query->where('properti_id', $filters['property_id']);
        }

        if ($filters['rating']) {
            $query->where('rating', $filters['rating']);
        }

        if ($filters['mood']) {
            $query->where('mood', $filters['mood']);
        }

        if ($filters['date_from']) {
            $query->whereDate('tanggal', '>=', $filters['date_from']);
        }

        if ($filters['date_to']) {
            $query->whereDate('tanggal', '<=', $filters['date_to']);
        }

        $this->applySorting($query, $filters['sort']);

        return $query;
    }

    /**
     * Apply sorting to the query.
     */
    protected function applySorting($query, string $sort): void
    {
        switch ($sort) {
            case 'oldest':
                $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc');
                break;
            case 'highest_rating':
                $query->orderBy('rating', 'desc')->orderBy('tanggal', 'desc');
                break;
            case 'lowest_rating':
                $query->orderBy('rating', 'asc')->orderBy('tanggal', 'desc');
                break;
            default:
                $query->orderBy('tanggal', 'desc')->orderBy('id', 'desc');
                break;
        }
    }

    /**
     * Extract filters from the incoming request with sensible defaults.
     */
    protected function filtersFromRequest(Request $request): array
    {
        return [
            'search' => trim($request->input('search', '')),
            'property_id' => $request->input('property_id', ''),
            'rating' => $request->input('rating', ''),
            'mood' => $request->input('mood', ''),
            'date_from' => $request->input('date_from', ''),
            'date_to' => $request->input('date_to', ''),
            'sort' => $request->input('sort', 'latest'),
        ];
    }

    /**
     * Mood options label mapping.
     */
    protected function moodOptions(): array
    {
        return [
            1 => __('Kurang puas'),
            2 => __('Cukup puas'),
            3 => __('Sangat puas'),
        ];
    }
}
