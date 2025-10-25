<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\SearchHistory;
use App\Models\VisitSchedule;
use App\Models\Properti;
use App\Models\DocumentUpload;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $searchHistories = $user
            ? SearchHistory::query()
                ->where('user_id', $user->id)
                ->latest('id')
                ->take(5)
                ->get()
            : collect();

        $favorites = collect();
        $favoritesCount = 0;
        if ($user) {
            $favorites = $user->favoriteProperties()
                ->with(['primaryMedia'])
                ->orderByDesc('property_favorites.created_at')
                ->take(3)
                ->get();

            $favoritesCount = $user->favoriteProperties()->count();
        }

        $upcomingVisits = collect();
        $upcomingCount = 0;
        if ($user) {
            $baseUpcoming = VisitSchedule::query()
                ->where('customer_id', $user->id)
                ->where('status', 'booked')
                ->where('start_at', '>=', now());

            $upcomingCount = (clone $baseUpcoming)->count();

            $upcomingVisits = (clone $baseUpcoming)
                ->with(['agent'])
                ->orderBy('start_at')
                ->take(3)
                ->get();
        }

        // Recommended properties: latest published listings (same source as Gallery)
        $recommendedProperties = Properti::query()
            ->with(['primaryMedia'])
            ->where('status', 'published')
            ->orderByDesc('updated_at')
            ->take(3)
            ->get();

        // Document status overview
        $documentRequirements = config('document-requirements', []);
        $documentLabels = collect($documentRequirements)
            ->mapWithKeys(fn ($meta, $key) => [$key => $meta['label'] ?? $key]);

        $documentUploads = collect();
        $missingDocuments = collect();
        $documentSummary = [
            'submitted' => 0,
            'approved' => 0,
            'rejected' => 0,
            'needs_revision' => 0,
        ];

        if ($user) {
            $documentUploads = DocumentUpload::query()
                ->where('user_id', $user->id)
                ->orderBy('document_type')
                ->get()
                ->keyBy('document_type');

            foreach ($documentUploads as $upload) {
                if (isset($documentSummary[$upload->status])) {
                    $documentSummary[$upload->status] += 1;
                }
            }

            $missingDocuments = collect(array_keys($documentRequirements))
                ->filter(fn ($key) => ! $documentUploads->has($key))
                ->map(fn ($key) => $documentLabels[$key] ?? $key)
                ->values();
        }

        return view('pelanggan.dashboard.index', [
            'role' => $user?->roleSlug() ?? config('roles.default', 'customer'),
            'searchHistories' => $searchHistories,
            'favorites' => $favorites,
            'favoritesCount' => $favoritesCount,
            'recommendedProperties' => $recommendedProperties,
            'documentUploads' => $documentUploads,
            'missingDocuments' => $missingDocuments,
            'documentSummary' => $documentSummary,
            'upcomingVisits' => $upcomingVisits,
            'upcomingCount' => $upcomingCount,
        ]);
    }
}
