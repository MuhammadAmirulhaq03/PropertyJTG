<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PropertyFilterService
{
    public function filter(Collection $properties, array $filters): Collection
    {
        $filtered = $properties;

        if (($filters['location'] ?? '') !== '') {
            $needle = Str::lower($filters['location']);
            $filtered = $filtered->filter(function (array $property) use ($needle) {
                $haystack = Str::lower(trim(($property['location'] ?? '').' '.($property['city'] ?? '')));

                return Str::contains($haystack, $needle);
            });
        }

        if (($filters['type'] ?? '') !== '') {
            $type = Str::lower($filters['type']);
            $filtered = $filtered->filter(fn (array $property) => Str::lower($property['type'] ?? '') === $type);
        }

        if (isset($filters['price_min']) && $filters['price_min'] !== null) {
            $filtered = $filtered->filter(fn (array $property) => (int) ($property['price'] ?? 0) >= $filters['price_min']);
        }

        if (isset($filters['price_max']) && $filters['price_max'] !== null) {
            $filtered = $filtered->filter(fn (array $property) => (int) ($property['price'] ?? 0) <= $filters['price_max']);
        }

        if (($filters['area_min'] ?? null) !== null || ($filters['area_max'] ?? null) !== null) {
            $filtered = $filtered->filter(function (array $property) use ($filters) {
                $primaryArea = (int) ($property['land_area'] ?? 0);
                if ($primaryArea === 0) {
                    $primaryArea = (int) ($property['building_area'] ?? 0);
                }

                if (($filters['area_min'] ?? null) !== null && $primaryArea < $filters['area_min']) {
                    return false;
                }

                if (($filters['area_max'] ?? null) !== null && $primaryArea > $filters['area_max']) {
                    return false;
                }

                return true;
            });
        }

        if (($filters['specs'] ?? '') !== '') {
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

        if (($filters['keywords'] ?? '') !== '') {
            $terms = collect(preg_split('/[,]+/', $filters['keywords']))
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

        return $filtered->sortBy('price')->values();
    }
}
