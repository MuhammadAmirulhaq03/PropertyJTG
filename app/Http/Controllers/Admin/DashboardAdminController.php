<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardMetricsService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardAdminController extends Controller
{
    public function __invoke(Request $request): View
    {
        $filters = [
            'range' => $request->input('range', '30'),
            'type' => $request->input('type', 'all'),
            'location' => $request->input('location', 'all'),
        ];

        // Use real metrics for KPI cards; fall back to placeholders on error
        try {
            /** @var DashboardMetricsService $metricsService */
            $metricsService = app(DashboardMetricsService::class);
            $realMetrics = $metricsService->metrics($filters['range'], $filters['type'], $filters['location']);
            $kpis = $this->mapKpisFromMetrics($realMetrics);
        } catch (\Throwable $e) {
            // Keep existing placeholder behaviour if metrics are not available
            $kpis = $this->generateKpis($filters);
        }
        $leadsByChannel = $this->generateLeadsByChannel($filters);
        $topListings = $this->generateTopListings($filters);
        $trendRaw = $this->generateTrendData($filters);
        $trendNormalized = [
            'views' => $this->normaliseSeries($trendRaw['views']),
            'leads' => $this->normaliseSeries($trendRaw['leads']),
        ];
        $trendPaths = [
            'views' => $this->buildPathSet($trendNormalized['views']),
            'leads' => $this->buildPathSet($trendNormalized['leads']),
        ];
        $leadSources = $this->generateLeadSources($filters);

        // Lightweight recent activities using real data where available
        $recentActivities = $this->buildRecentActivities((int) $filters['range']);

        return view('admin.dashboard.index', [
            'filters' => $filters,
            'kpis' => $kpis,
            'leadsByChannel' => $leadsByChannel,
            'topListings' => $topListings,
            'trend' => array_merge($trendRaw, [
                'normalized' => $trendNormalized,
                'paths' => $trendPaths,
            ]),
            'leadSources' => $leadSources,
            'recentActivities' => $recentActivities,
        ]);
    }

    private function generateKpis(array $filters): array
    {
        $baseMultiplier = $this->rangeMultiplier($filters['range']);
        $typeModifier = $filters['type'] !== 'all' ? 0.85 : 1.0;
        $locationModifier = $filters['location'] !== 'all' ? 0.9 : 1.0;

        $scale = $baseMultiplier * $typeModifier * $locationModifier;

        return [
            [
                'label' => __('Property views'),
                'value' => number_format((int) (125000 * $scale)),
                'trend' => $this->trend(),
                'icon' => $this->icon('view'),
            ],
            [
                'label' => __('Leads generated'),
                'value' => number_format((int) (3800 * $scale)),
                'trend' => $this->trend(),
                'icon' => $this->icon('leads'),
            ],
            [
                'label' => __('Average engagement'),
                'value' => number_format(62 * $scale, 1) . '%',
                'trend' => $this->trend(),
                'icon' => $this->icon('engagement'),
            ],
            [
                'label' => __('Conversion rate'),
                'value' => number_format(4.7 * $scale, 1) . '%',
                'trend' => $this->trend(),
                'icon' => $this->icon('conversion'),
            ],
        ];
    }

    /**
     * Map real metrics to the 4 KPI cards expected by the view.
     *
     * @param array{
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
     * } $m
     * @return array<int, array{label:string,value:string,trend:int,icon:string}>
     */
    private function mapKpisFromMetrics(array $m): array
    {
        return [
            [
                'label' => __('Active listings'),
                'value' => number_format($m['active_listings']) . '  •  +' . number_format($m['updated_listings']),
                'trend' => 0,
                'icon' => $this->icon('view'),
            ],
            [
                'label' => __('Upcoming visits'),
                'value' => number_format($m['upcoming_visits']) . '  •  +' . number_format($m['new_enquiries']),
                'trend' => 0,
                'icon' => $this->icon('leads'),
            ],
            [
                'label' => __('Documents (pending/claimed)'),
                'value' => number_format($m['pending_documents']) . ' / ' . number_format($m['claimed_documents']),
                'trend' => 0,
                'icon' => $this->icon('engagement'),
            ],
            [
                'label' => __('Customers (new/active)') . ($m['avg_rating'] !== null ? ' • ' . __('Avg rating') : ''),
                'value' => number_format($m['new_customers']) . ' / ' . number_format($m['active_users']) . ($m['avg_rating'] !== null ? ' • ' . number_format($m['avg_rating'], 1) : ''),
                'trend' => 0,
                'icon' => $this->icon('conversion'),
            ],
        ];
    }

    private function generateLeadsByChannel(array $filters): array
    {
        // Real breakdown: document statuses
        $statuses = [
            'Submitted' => \App\Models\DocumentUpload::STATUS_SUBMITTED,
            'Needs Revision' => \App\Models\DocumentUpload::STATUS_REVISION,
            'Approved' => \App\Models\DocumentUpload::STATUS_APPROVED,
            'Rejected' => \App\Models\DocumentUpload::STATUS_REJECTED,
        ];

        $rows = [];
        $total = 0;
        foreach ($statuses as $label => $status) {
            $count = \App\Models\DocumentUpload::query()->where('status', $status)->count();
            $rows[] = ['label' => __($label), 'value' => $count];
            $total += $count;
        }

        $total = $total ?: 1;
        return array_map(function ($row) use ($total) {
            return [
                'label' => $row['label'],
                'value' => $row['value'],
                'percentage' => (int) round(($row['value'] / $total) * 100),
            ];
        }, $rows);
    }

    private function generateTopListings(array $filters): array
    {
        $query = \App\Models\Properti::query()->withCount('favoritedBy')->orderByDesc('favorited_by_count');

        if (($filters['type'] ?? 'all') !== 'all') {
            $typeFilter = Str::lower(Str::headline($filters['type']));
            $query->where(function ($q) use ($typeFilter) {
                $q->whereRaw('lower(tipe) = ?', [$typeFilter])
                  ->orWhereRaw('lower(tipe_properti) = ?', [$typeFilter]);
            });
        }

        $rows = $query->take(8)->get();

        return $rows->map(function ($p) {
            return [
                'name' => $p->nama,
                'location' => (string) $p->lokasi,
                'type' => (string) ($p->tipe ?: $p->tipe_properti ?: __('Property')),
                'views' => (int) $p->favorited_by_count,
                'leads' => 0,
            ];
        })->all();
    }

    private function rangeMultiplier(string $range): float
    {
        return match ($range) {
            '7' => 0.4,
            '30' => 1.0,
            '90' => 2.1,
            '365' => 4.8,
            default => 1.0,
        };
    }

    private function trend(): int
    {
        return random_int(-8, 15);
    }

    private function icon(string $type): string
    {
        return match ($type) {
            'view' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>',
            'leads' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0a3 3 0 00-5.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20a3 3 0 005.356-1.857M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zm-14 0a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
            'engagement' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 10c0 3.866-3.582 7-8 7a8.66 8.66 0 01-3.955-.93L3 18l1.512-3.53A6.708 6.708 0 015 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" /></svg>',
            'conversion' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 1.791-3 4s1.343 4 3 4 3-1.791 3-4-1.343-4-3-4z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.5 10a8.38 8.38 0 011.05-2.977l-1.862-1.86a10.47 10.47 0 00-1.72 4.837H5.5zm0 4H3.968a10.471 10.471 0 001.72 4.837l1.862-1.86A8.38 8.38 0 015.5 14zm12.054-7.977L15.692 7.86A8.377 8.377 0 0118.5 10h1.532a10.47 10.47 0 00-1.72-4.837zM18.5 14a8.377 8.377 0 01-2.808 2.14l1.862 1.86a10.471 10.471 0 001.72-4.837H18.5z" /></svg>',
            default => '',
        };
    }

    private function generateTrendData(array $filters): array
    {
        // Real trend: Favorites and Visits over the range, split into buckets
        $days = (int) ($filters['range'] ?? 30) ?: 30;
        $segments = match ($days) {
            7 => 7,
            30 => 10,
            90 => 12,
            365 => 12,
            default => 10,
        };

        $to = now();
        $from = now()->subDays($days);

        $buckets = $this->segmentTimeRange($from, $to, $segments);
        $labels = [];
        $favoritesCounts = [];
        $visitCounts = [];

        $typeFilter = strtolower((string) ($filters['type'] ?? 'all'));
        $locationFilter = strtolower((string) ($filters['location'] ?? 'all'));
        $locationLike = $locationFilter !== 'all' ? str_replace('-', ' ', $locationFilter) : null;

        foreach ($buckets as [$start, $end]) {
            $labels[] = $start->format('d M') . '–' . $end->format('d M');

            $favQuery = \App\Models\PropertyFavorite::query()
                ->join('propertis', 'property_favorites.properti_id', '=', 'propertis.id')
                ->whereBetween('property_favorites.created_at', [$start, $end]);

            if ($typeFilter !== 'all') {
                $typeNorm = strtolower(\Illuminate\Support\Str::headline($typeFilter));
                $favQuery->where(function ($q) use ($typeNorm) {
                    $q->whereRaw('lower(propertis.tipe) = ?', [$typeNorm])
                      ->orWhereRaw('lower(propertis.tipe_properti) = ?', [$typeNorm]);
                });
            }
            if ($locationLike) {
                $favQuery->whereRaw('lower(propertis.lokasi) like ?', ['%' . $locationLike . '%']);
            }
            $favoritesCounts[] = $favQuery->count();

            // Visits kept global; optionally filter by location if you later normalise VisitSchedule.location
            $vis = \App\Models\VisitSchedule::query()
                ->where('status', 'booked')
                ->whereBetween('booked_at', [$start, $end])
                ->count();
            $visitCounts[] = $vis;
        }

        return [
            'labels' => $labels,
            'views' => $favoritesCounts,
            'leads' => $visitCounts,
        ];
    }

    private function generateLeadSources(array $filters): array
    {
        $favBase = \App\Models\PropertyFavorite::query()
            ->join('propertis', 'property_favorites.properti_id', '=', 'propertis.id');
        if (($filters['location'] ?? 'all') !== 'all') {
            $like = str_replace('-', ' ', strtolower($filters['location']));
            $favBase->whereRaw('lower(propertis.lokasi) like ?', ['%'.$like.'%']);
        }
        if (($filters['type'] ?? 'all') !== 'all') {
            $typeFilter = Str::lower(Str::headline($filters['type']));
            $favBase->where(function ($q) use ($typeFilter) {
                $q->whereRaw('lower(propertis.tipe) = ?', [$typeFilter])
                  ->orWhereRaw('lower(propertis.tipe_properti) = ?', [$typeFilter]);
            });
        }
        $rows = $favBase
            ->selectRaw("COALESCE(propertis.tipe, propertis.tipe_properti, 'Other') as tipe, COUNT(*) as cnt")
            ->groupByRaw("COALESCE(propertis.tipe, propertis.tipe_properti, 'Other')")
            ->orderByDesc('cnt')
            ->get();

        $labels = $rows->pluck('tipe')->map(fn($t) => (string) $t)->all();
        $values = $rows->pluck('cnt')->map(fn($v) => (int) $v)->all();
        $total = array_sum($values) ?: 1;
        $percentages = array_map(fn($v) => round(($v / $total) * 100, 1), $values);

        return [
            'labels' => $labels,
            'values' => $values,
            'percentages' => $percentages,
        ];
    }

    /**
     * Split a time range into N contiguous buckets.
     * @return array<int, array{0:\Carbon\CarbonInterface,1:\Carbon\CarbonInterface}>
     */
    private function segmentTimeRange($from, $to, int $segments): array
    {
        $totalSeconds = max(1, $to->diffInSeconds($from));
        $step = (int) floor($totalSeconds / $segments);
        $buckets = [];
        $cursor = $from->copy();
        for ($i = 0; $i < $segments; $i++) {
            $end = $i === $segments - 1 ? $to->copy() : $cursor->copy()->addSeconds($step);
            $buckets[] = [$cursor->copy(), $end->copy()];
            $cursor = $end;
        }
        return $buckets;
    }

    /**
     * @param  array<int, int|float>  $series
     * @return array<int, float>
     */
    private function normaliseSeries(array $series): array
    {
        $max = max($series);

        if ($max <= 0) {
            return array_fill(0, count($series), 0.0);
        }

        return array_map(
            fn ($value) => round(($value / $max) * 100, 2),
            $series
        );
    }

    /**
     * @param  array<int, float>  $series
     * @return array{line:string, area:string, points:array<int, array{ x:float, y:float }>}
     */
    private function buildPathSet(array $series): array
    {
        $count = count($series);

        if ($count === 0) {
            return ['line' => '', 'area' => '', 'points' => []];
        }

        if ($count === 1) {
            $x = 0.0;
            $y = 100 - $series[0];

            return [
                'line' => sprintf('M %.2f %.2f', $x, $y),
                'area' => sprintf('M %.2f %.2f L %.2f 100 L 0 100 Z', $x, $y, $x),
                'points' => [['x' => $x, 'y' => $y]],
            ];
        }

        $step = 100 / ($count - 1);
        $points = [];

        foreach ($series as $index => $value) {
            $x = $step * $index;
            $y = 100 - $value;

            $points[] = [
                'x' => round($x, 2),
                'y' => round($y, 2),
            ];
        }

        $line = 'M ' . sprintf('%.2f %.2f', $points[0]['x'], $points[0]['y']);
        for ($i = 1; $i < count($points); $i++) {
            $line .= ' L ' . sprintf('%.2f %.2f', $points[$i]['x'], $points[$i]['y']);
        }

        $lastPoint = end($points);
        $area = $line . sprintf(' L %.2f 100 L 0 100 Z', $lastPoint['x']);

        return [
            'line' => $line,
            'area' => $area,
            'points' => $points,
        ];
    }

    /**
     * Build a small recent activities feed across key entities.
     *
     * @return array<int, array{type:string,time:\DateTimeInterface|null,title:string,description:string}>
     */
    private function buildRecentActivities(int $rangeDays = 30): array
    {
        try {
            $from = now()->subDays(max(1, $rangeDays));

            $visits = \App\Models\VisitSchedule::query()
                ->where('status', 'booked')
                ->where('booked_at', '>=', $from)
                ->orderByDesc('booked_at')
                ->take(5)
                ->get()
                ->map(function ($s) {
                    return [
                        'type' => 'visit_booked',
                        'time' => $s->booked_at ?? $s->updated_at,
                        'title' => __('New visit booked'),
                        'description' => optional($s->start_at)->translatedFormat('d M Y H:i') . ' • ' . ($s->location ?: __('No location')),
                    ];
                });

            $docReviews = \App\Models\DocumentUpload::query()
                ->whereNotNull('reviewed_by')
                ->whereNotNull('reviewed_at')
                ->where('reviewed_at', '>=', $from)
                ->orderByDesc('reviewed_at')
                ->take(5)
                ->get()
                ->map(function ($d) {
                    return [
                        'type' => 'document_reviewed',
                        'time' => $d->reviewed_at ?? $d->updated_at,
                        'title' => __('Document reviewed'),
                        'description' => str_replace('_', ' ', (string) $d->document_type) . ' • ' . $d->statusLabel(),
                    ];
                });

            $listingUpdates = \App\Models\Properti::query()
                ->where('status', 'published')
                ->where('updated_at', '>=', $from)
                ->orderByDesc('updated_at')
                ->take(5)
                ->get()
                ->map(function ($p) {
                    return [
                        'type' => 'listing_updated',
                        'time' => $p->updated_at,
                        'title' => __('Listing updated'),
                        'description' => $p->nama . ' • ' . ($p->lokasi ?: __('Unknown location')),
                    ];
                });

            $feedbacks = \App\Models\Feedback::query()
                ->where('created_at', '>=', $from)
                ->orderByDesc('created_at')
                ->take(5)
                ->get()
                ->map(function ($f) {
                    return [
                        'type' => 'feedback',
                        'time' => $f->created_at,
                        'title' => __('New feedback'),
                        'description' => __('Rating') . ': ' . (int) $f->rating,
                    ];
                });

            // New customer registrations within range
            $registrations = \App\Models\User::query()
                ->where('role', 'customer')
                ->where('created_at', '>=', $from)
                ->orderByDesc('created_at')
                ->take(5)
                ->get()
                ->map(function ($u) {
                    return [
                        'type' => 'user_registered',
                        'time' => $u->created_at,
                        'title' => __('New registration'),
                        'description' => ($u->name ?: $u->email) . ' • ' . \Illuminate\Support\Str::headline((string) $u->role),
                    ];
                });

            // Property favorites within range
            $favorites = \App\Models\PropertyFavorite::query()
                ->with(['user', 'property'])
                ->where('created_at', '>=', $from)
                ->orderByDesc('created_at')
                ->take(5)
                ->get()
                ->map(function ($fav) {
                    $userName = optional($fav->user)->name ?: __('Customer');
                    $propName = optional($fav->property)->nama ?: __('Property');
                    return [
                        'type' => 'favorite',
                        'time' => $fav->created_at,
                        'title' => __('Property favorited'),
                        'description' => $userName . ' → ' . $propName,
                    ];
                });

            return $docReviews
                ->merge($visits)
                ->merge($listingUpdates)
                ->merge($feedbacks)
                ->merge($registrations)
                ->merge($favorites)
                ->sortByDesc('time')
                ->take(8)
                ->values()
                ->all();
        } catch (\Throwable $e) {
            return [];
        }
    }
}
