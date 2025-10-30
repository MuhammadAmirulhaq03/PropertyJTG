<?php

namespace App\Services\Admin;

use App\Models\DocumentUpload;
use App\Models\Feedback;
use App\Models\Properti;
use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardMetricsService
{
    /**
     * Compute lightweight, real metrics for the admin dashboard.
     * Cached for a few minutes to avoid heavy queries on every load.
     *
     * @param string|int $rangeDays 7|30|90|365
     * @return array{
     *   active_listings:int,
     *   updated_listings:int,
     *   upcoming_visits:int,
     *   new_enquiries:int,
     *   pending_documents:int,
     *   claimed_documents:int,
     *   unclaimed_documents:int,
     *   new_customers:int,
     *   active_users:int,
     *   avg_rating:float|null
     * }
     */
    public function metrics(string|int $rangeDays): array
    {
        $days = (int) $rangeDays ?: 30;
        $cacheKey = "admin:metrics:v1:{$days}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($days) {
            $from = Carbon::now()->subDays($days);
            $to = Carbon::now();

            $activeListings = Properti::query()->where('status', 'published')->count();
            $updatedListings = Properti::query()->where('status', 'published')->where('updated_at', '>=', $from)->count();

            $upcomingVisits = VisitSchedule::query()->where('status', 'booked')->where('start_at', '>=', $to)->count();
            $newEnquiries = VisitSchedule::query()->where('status', 'booked')->whereBetween('booked_at', [$from, $to])->count();

            $pendingDocs = DocumentUpload::query()->whereIn('status', [
                DocumentUpload::STATUS_SUBMITTED,
                DocumentUpload::STATUS_REVISION,
            ])->count();
            $claimedDocs = DocumentUpload::query()->whereNotNull('reviewed_by')->count();
            $unclaimedDocs = DocumentUpload::query()->whereNull('reviewed_by')->count();

            $newCustomers = User::query()->where('role', 'customer')->whereBetween('created_at', [$from, $to])->count();
            $activeUsers = User::query()->where('last_seen_at', '>=', Carbon::now()->subDay())->count();

            $avgRating = Feedback::query()->whereBetween('created_at', [$from, $to])->avg('rating');
            $avgRating = $avgRating ? (float) $avgRating : null;

            return [
                'active_listings' => $activeListings,
                'updated_listings' => $updatedListings,
                'upcoming_visits' => $upcomingVisits,
                'new_enquiries' => $newEnquiries,
                'pending_documents' => $pendingDocs,
                'claimed_documents' => $claimedDocs,
                'unclaimed_documents' => $unclaimedDocs,
                'new_customers' => $newCustomers,
                'active_users' => $activeUsers,
                'avg_rating' => $avgRating,
            ];
        });
    }
}

