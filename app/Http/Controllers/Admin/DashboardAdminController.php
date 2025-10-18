<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        $kpis = $this->generateKpis($filters);
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

    private function generateLeadsByChannel(array $filters): array
    {
        $channels = [
            ['label' => __('Website'), 'value' => 1420],
            ['label' => __('Instagram'), 'value' => 980],
            ['label' => __('Marketplace'), 'value' => 720],
            ['label' => __('Referral'), 'value' => 510],
        ];

        $modifier = $this->rangeMultiplier($filters['range']);
        if ($filters['type'] !== 'all') {
            $modifier *= 0.9;
        }

        $max = max(array_column($channels, 'value'));

        return collect($channels)->map(function ($channel) use ($modifier, $max) {
            $value = (int) ($channel['value'] * $modifier);
            return [
                'label' => $channel['label'],
                'value' => $value,
                'percentage' => (int) (($value / ($max ?: 1)) * 100),
            ];
        })->all();
    }

    private function generateTopListings(array $filters): array
    {
        $listings = [
            ['name' => 'Serenity Lakeside Villa', 'location' => 'Pondok Indah', 'type' => 'Villa', 'views' => 12340, 'leads' => 210],
            ['name' => 'Urban Heights Apartment', 'location' => 'Sudirman', 'type' => 'Apartment', 'views' => 9875, 'leads' => 185],
            ['name' => 'Central Business Loft', 'location' => 'Kuningan', 'type' => 'Commercial', 'views' => 8560, 'leads' => 142],
            ['name' => 'Greenwood Family House', 'location' => 'BSD City', 'type' => 'House', 'views' => 7320, 'leads' => 118],
        ];

        $typeFilter = Str::headline($filters['type'] ?? '');

        return collect($listings)
            ->filter(function ($listing) use ($filters, $typeFilter) {
                if ($filters['type'] !== 'all' && Str::lower($listing['type']) !== Str::lower($typeFilter)) {
                    return false;
                }

                if ($filters['location'] !== 'all' && !Str::contains(Str::slug($listing['location']), $filters['location'])) {
                    return false;
                }

                return true;
            })
            ->values()
            ->all();
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
        $range = (int) $filters['range'];
        $points = match ($range) {
            7 => 7,
            30 => 10,
            90 => 12,
            365 => 12,
            default => 10,
        };

        $labels = collect(range(1, $points))->map(fn ($index) => __('Week') . ' ' . $index)->all();

        $baseViews = 8000 * $this->rangeMultiplier($filters['range']);
        $baseLeads = 300 * $this->rangeMultiplier($filters['range']);

        $views = collect(range(1, $points))->map(function ($point) use ($baseViews) {
            return (int) ($baseViews * (0.6 + ($point / 12)) + random_int(-900, 900));
        })->all();

        $leads = collect(range(1, $points))->map(function ($point) use ($baseLeads) {
            return (int) ($baseLeads * (0.5 + ($point / 10)) + random_int(-60, 60));
        })->all();

        return [
            'labels' => $labels,
            'views' => $views,
            'leads' => $leads,
        ];
    }

    private function generateLeadSources(array $filters): array
    {
        $channels = ['Website', 'Social', 'Marketplace', 'Referral'];
        $baseValues = [45, 25, 18, 12];

        if ($filters['type'] !== 'all') {
            $baseValues = array_map(fn ($value) => (int) ($value * 0.95), $baseValues);
        }

        if ($filters['location'] !== 'all') {
            $baseValues[1] += 5;
            $baseValues[2] -= 3;
        }

        $total = array_sum($baseValues) ?: 1;

        return [
            'labels' => $channels,
            'values' => $baseValues,
            'percentages' => array_map(
                fn ($value) => round(($value / $total) * 100, 1),
                $baseValues
            ),
        ];
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
}
