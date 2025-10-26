<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\VisitSchedule;
use App\Models\DocumentUpload;
use App\Models\Properti;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $upcoming = collect();
        $bookedCount = 0;
        $recentActivities = collect();

        if ($user) {
            $base = VisitSchedule::query()
                ->where('agent_id', $user->id)
                ->where('status', 'booked');

            $bookedCount = (clone $base)->count();

            $upcoming = (clone $base)
                ->where('start_at', '>=', now())
                ->orderBy('start_at')
                ->take(5)
                ->get();
            // Recent document reviews by this agent
            $docReviews = DocumentUpload::query()
                ->where('reviewed_by', $user->id)
                ->orderByDesc('reviewed_at')
                ->take(5)
                ->get()
                ->map(function (DocumentUpload $doc) {
                    return [
                        'type' => 'document_reviewed',
                        'time' => $doc->reviewed_at ?? $doc->updated_at,
                        'title' => __('Reviewed :type', ['type' => str_replace('_', ' ', $doc->document_type)]),
                        'description' => __('Status set to :status', ['status' => $doc->statusLabel()]),
                    ];
                })
                ->values()
                ->toBase();

            // New bookings assigned to this agent in the last 7 days
            $recentBookings = VisitSchedule::query()
                ->where('agent_id', $user->id)
                ->where('status', 'booked')
                ->where('booked_at', '>=', now()->subDays(7))
                ->orderByDesc('booked_at')
                ->take(5)
                ->get()
                ->map(function (VisitSchedule $s) {
                    return [
                        'type' => 'visit_booked',
                        'time' => $s->booked_at ?? $s->updated_at,
                        'title' => __('New visit booked'),
                        'description' => optional($s->start_at)->translatedFormat('l, d M Y H:i') . ' • ' . ($s->location ?: __('No location')),
                    ];
                })
                ->values()
                ->toBase();

            $recentActivities = $docReviews->merge($recentBookings)
                ->sortByDesc('time')
                ->take(5)
                ->values();

            // Agent stats for highlight banner
            $activeListings = Properti::query()->where('status', 'published')->count();
            $activeListingsDelta = Properti::query()->where('status', 'published')->where('updated_at', '>=', now()->subDays(7))->count();

            $newEnquiriesCount = (clone $base)->where('booked_at', '>=', now()->subDays(7))->count();

            $pendingDocsCount = DocumentUpload::query()->whereIn('status', [
                DocumentUpload::STATUS_SUBMITTED,
                DocumentUpload::STATUS_REVISION,
            ])->count();

            $scheduledVisitsCount = (clone $base)->where('start_at', '>=', now())->count();
            $nextVisit = (clone $base)->where('start_at', '>=', now())->orderBy('start_at')->first();

            $agentStats = [
                [
                    'title' => __('Active Listings'),
                    'value' => (string) $activeListings,
                    'change' => __('+:count updated this week', ['count' => $activeListingsDelta]),
                ],
                [
                    'title' => __('New Enquiries'),
                    'value' => (string) $newEnquiriesCount,
                    'change' => __('last 7 days'),
                ],
                [
                    'title' => __('Pending Documents'),
                    'value' => (string) $pendingDocsCount,
                    'change' => __('Awaiting review'),
                ],
                [
                    'title' => __('Scheduled Visits'),
                    'value' => (string) $scheduledVisitsCount,
                    'change' => $nextVisit ? __('Next: :time', ['time' => optional($nextVisit->start_at)->translatedFormat('d M H:i')]) : __('No upcoming'),
                ],
            ];
        }

        return view('agen.dashboard.index', [
            'showAdminExtras' => false,
            'role' => $user?->roleSlug() ?? 'agen',
            'agentUpcoming' => $upcoming,
            'agentBookedCount' => $bookedCount,
            'recentActivities' => $recentActivities,
            'agentStats' => $agentStats ?? [],
        ]);
    }
}
