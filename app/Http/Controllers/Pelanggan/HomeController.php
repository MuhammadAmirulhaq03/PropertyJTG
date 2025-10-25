<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Properti;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProperties = Properti::query()
            ->with(['primaryMedia'])
            ->where('status', 'published')
            ->orderByDesc('updated_at')
            ->limit(6)
            ->get();

        return view('pelanggan.home.index', [
            'featuredProperties' => $featuredProperties,
        ]);
    }

    public function search(Request $request): View
    {
        $properties = collect(config('properties', []));

        $filters = [
            'location' => trim((string) $request->input('location', '')),
            'type' => $request->input('type', ''),
            'price_min' => $request->filled('price_min') ? (int) $request->input('price_min') : null,
            'price_max' => $request->filled('price_max') ? (int) $request->input('price_max') : null,
            'area_min' => $request->filled('area_min') ? (int) $request->input('area_min') : null,
            'area_max' => $request->filled('area_max') ? (int) $request->input('area_max') : null,
            'specs' => trim((string) $request->input('specs', '')),
            'keywords' => trim((string) $request->input('keywords', '')),
        ];

        $filtered = $this->applyFilters($properties, $filters);
        $activeFilters = $this->buildActiveFilters($filters);

        // Disabled: do not record search history in profile anymore
        // $this->recordSearchHistory($request, $filters, $activeFilters);

        return view('pelanggan.home.search-results', [
            'properties' => $filtered,
            'total' => $filtered->count(),
            'filters' => $filters,
            'activeFilters' => $activeFilters,
            'hasActiveFilters' => !empty($activeFilters),
        ]);
    }

    public function houseView(): View
    {
        $quickFacts = [
            ['label' => 'Cluster', 'value' => 'District 1'],
            ['label' => 'Bedrooms', 'value' => '2 Bedrooms'],
            ['label' => 'Bathrooms', 'value' => '1 Bathroom'],
            ['label' => 'Building Area', 'value' => '±36 m²'],
            ['label' => 'Land Area', 'value' => '±6 x 12 m'],
            ['label' => 'Carport', 'value' => '1 Vehicle'],
        ];

        $technicalSpecifications = [
            ['feature' => 'Pondasi', 'district1' => 'Foot foundation', 'district2' => 'Coming Soon'],
            ['feature' => 'Dinding', 'district1' => 'White color painted', 'district2' => 'Coming Soon'],
            ['feature' => 'Lantai', 'district1' => 'Homogenous tile 0.60 x 0.60 white color, plain + grouting nat light grey color', 'district2' => 'Coming Soon'],
            ['feature' => 'Kusen & Pintu', 'district1' => 'Wooden leave door furnish finish + aluminium frame powder coated black + stainless accessories', 'district2' => 'Coming Soon'],
            ['feature' => 'Jendela', 'district1' => 'Aluminium frame + casement (openable) powder coated black finish + clear glass 8 mm + stainless accessories', 'district2' => 'Coming Soon'],
            ['feature' => 'Plafon', 'district1' => 'Gypsum board 9 mm white color painted finish / uPVC 0.8 mm', 'district2' => 'Coming Soon'],
            ['feature' => 'Atap', 'district1' => 'uPVC surface + list plank + ceiling + light steel structure / zinc dark brown color + list plank plywood + ceiling kalsiboard white color finish', 'district2' => 'Coming Soon'],
            ['feature' => 'Water Supply', 'district1' => 'Deep well system', 'district2' => 'Coming Soon'],
        ];

        $designImages = [
            ['title' => 'House Front Perspective', 'description' => 'Facade concept with modern tropical lines and welcoming terrace.', 'path' => 'assets/asset jtg1.jpg'],
            ['title' => 'Living & Dining Concept', 'description' => 'Open living area connecting to kitchen for functional daily flow.', 'path' => 'assets/asset jtg 2.jpg'],
            ['title' => 'Floor Plan Overview', 'description' => 'District 1 floor plan featuring 2 bedrooms and integrated wet area.', 'path' => 'assets/house jtg1.jpg'],
        ];

        $amenities = [
            [
                'name' => 'SKA (10 Km)',
                'tag' => 'Mall Shopping',
                'description' => 'Regional shopping mall with retail, dining, and convention center that serves as the lifestyle hub for Pekanbaru.',
            ],
            [
                'name' => 'AKAP Terminal (6.5 Km)',
                'tag' => 'Bus Station',
                'description' => 'Payung Sekaki terminal with intercity buses connecting Pekanbaru to Sumatra, Java, and major neighboring regions.',
            ],
            [
                'name' => 'UNRI (9.5 Km)',
                'tag' => 'University',
                'description' => 'Universitas Riau campus supporting education, collaboration, and continuous community development.',
            ],
        ];

        return view('pelanggan.home.house-view', [
            'quickFacts' => $quickFacts,
            'technicalSpecifications' => $technicalSpecifications,
            'designImages' => $designImages,
            'amenities' => $amenities,
            'mapImage' => 'assets/house map 2.png',
        ]);
    }

    private function applyFilters(Collection $properties, array $filters): Collection
    {
        $filtered = $properties;

        if ($filters['location'] !== '') {
            $needle = Str::lower($filters['location']);

            $filtered = $filtered->filter(function (array $property) use ($needle) {
                $haystack = Str::lower(
                    trim(($property['location'] ?? '') . ' ' . ($property['city'] ?? ''))
                );

                return Str::contains($haystack, $needle);
            });
        }

        if ($filters['type'] !== '') {
            $type = Str::lower($filters['type']);

            $filtered = $filtered->filter(function (array $property) use ($type) {
                return Str::lower($property['type'] ?? '') === $type;
            });
        }

        if (!is_null($filters['price_min'])) {
            $filtered = $filtered->filter(function (array $property) use ($filters) {
                return (int) ($property['price'] ?? 0) >= $filters['price_min'];
            });
        }

        if (!is_null($filters['price_max'])) {
            $filtered = $filtered->filter(function (array $property) use ($filters) {
                return (int) ($property['price'] ?? 0) <= $filters['price_max'];
            });
        }

        if (!is_null($filters['area_min']) || !is_null($filters['area_max'])) {
            $filtered = $filtered->filter(function (array $property) use ($filters) {
                $primaryArea = (int) ($property['land_area'] ?? 0);
                if ($primaryArea === 0) {
                    $primaryArea = (int) ($property['building_area'] ?? 0);
                }

                if (!is_null($filters['area_min']) && $primaryArea < $filters['area_min']) {
                    return false;
                }

                if (!is_null($filters['area_max']) && $primaryArea > $filters['area_max']) {
                    return false;
                }

                return true;
            });
        }

        if ($filters['specs'] !== '') {
            $terms = collect(preg_split('/[,]+/', $filters['specs']))
                ->map(fn ($term) => Str::of($term)->lower()->trim()->toString())
                ->filter()
                ->values();

            if ($terms->isNotEmpty()) {
                $filtered = $filtered->filter(function (array $property) use ($terms) {
                    $haystack = Str::lower(implode(' ', $property['specs'] ?? []));

                    return $terms->every(fn ($term) => Str::contains($haystack, $term));
                });
            }
        }

        if ($filters['keywords'] !== '') {
            $terms = collect(preg_split('/[\s,]+/', $filters['keywords']))
                ->map(fn ($term) => Str::of($term)->lower()->trim()->toString())
                ->filter()
                ->values();

            if ($terms->isNotEmpty()) {
                $filtered = $filtered->filter(function (array $property) use ($terms) {
                    $segments = [
                        $property['title'] ?? '',
                        $property['location'] ?? '',
                        $property['city'] ?? '',
                        $property['description'] ?? '',
                        implode(' ', $property['specs'] ?? []),
                        implode(' ', $property['keywords'] ?? []),
                    ];

                    $haystack = Str::lower(implode(' ', $segments));

                    return $terms->every(fn ($term) => Str::contains($haystack, $term));
                });
            }
        }

        return $filtered
            ->sortBy('price')
            ->values();
    }

    private function buildActiveFilters(array $filters): array
    {
        $summary = [];

        if ($filters['location'] !== '') {
            $summary['Location'] = $filters['location'];
        }

        if ($filters['type'] !== '') {
            $summary['Type'] = Str::headline($filters['type']);
        }

        if (!is_null($filters['price_min']) || !is_null($filters['price_max'])) {
            $parts = [];

            if (!is_null($filters['price_min'])) {
                $parts[] = 'min ' . $this->formatCurrency($filters['price_min']);
            }

            if (!is_null($filters['price_max'])) {
                $parts[] = 'max ' . $this->formatCurrency($filters['price_max']);
            }

            $summary['Budget'] = implode(' - ', $parts);
        }

        if (!is_null($filters['area_min']) || !is_null($filters['area_max'])) {
            $parts = [];

            if (!is_null($filters['area_min'])) {
                $parts[] = 'min ' . $filters['area_min'] . ' m2';
            }

            if (!is_null($filters['area_max'])) {
                $parts[] = 'max ' . $filters['area_max'] . ' m2';
            }

            $summary['Size'] = implode(' - ', $parts);
        }

        if ($filters['specs'] !== '') {
            $summary['Specifications'] = $filters['specs'];
        }

        if ($filters['keywords'] !== '') {
            $summary['Keywords'] = $filters['keywords'];
        }

        return $summary;
    }

    private function formatCurrency(int $value): string
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    private function recordSearchHistory(Request $request, array $filters, array $activeFilters): void
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole('customer')) {
            return;
        }

        $meaningfulFilters = collect($filters)->reject(fn ($value) => $value === '' || is_null($value));

        if ($meaningfulFilters->isEmpty()) {
            return;
        }

        $payload = [
            'raw' => $filters,
            'active' => $activeFilters,
        ];

        $latest = SearchHistory::query()
            ->where('user_id', $user->id)
            ->latest('id')
            ->first();

        if ($latest && $latest->filters === $payload) {
            $latest->touch();

            return;
        }

        SearchHistory::create([
            'user_id' => $user->id,
            'filters' => $payload,
        ]);

        $excessIds = SearchHistory::query()
            ->where('user_id', $user->id)
            ->latest('id')
            ->skip(10)
            ->pluck('id');

        if ($excessIds->isNotEmpty()) {
            SearchHistory::query()
                ->whereIn('id', $excessIds)
                ->delete();
        }
    }
}
