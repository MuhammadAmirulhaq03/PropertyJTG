<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Properti;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyGalleryController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->input('q', '')),
            'type' => (string) $request->input('type', ''),
            'price_min' => $request->filled('price_min') ? (int) $request->input('price_min') : null,
            'price_max' => $request->filled('price_max') ? (int) $request->input('price_max') : null,
        ];

        $query = Properti::query()
            ->with(['media' => fn ($query) => $query->orderBy('is_primary', 'desc')->orderBy('sort_order')])
            ->where('status', 'published');

        if ($filters['q'] !== '') {
            $term = $filters['q'];
            $query->where(function ($q) use ($term) {
                $q->where('nama', 'like', "%{$term}%")
                  ->orWhere('lokasi', 'like', "%{$term}%")
                  ->orWhere('spesifikasi', 'like', "%{$term}%")
                  ->orWhere('deskripsi', 'like', "%{$term}%");
            });
        }

        if ($filters['type'] !== '') {
            $query->where('tipe_properti', $filters['type']);
        }

        if (!is_null($filters['price_min'])) {
            $query->where('harga', '>=', $filters['price_min']);
        }

        if (!is_null($filters['price_max'])) {
            $query->where('harga', '<=', $filters['price_max']);
        }

        $properties = $query->orderByDesc('updated_at')->get();

        $favoritePropertyIds = collect();
        $user = $request->user();

        if ($user && $user->hasRole('customer')) {
            $favoritePropertyIds = $user->propertyFavorites()->pluck('properti_id');
        }

        $types = [
            'residensial' => 'Residensial',
            'komersial' => 'Komersial',
            'apartemen' => 'Apartemen',
            'tanah' => 'Tanah Kosong',
            'lainnya' => 'Lainnya',
        ];

        return view('pelanggan.gallery.index', [
            'properties' => $properties,
            'types' => $types,
            'favoritePropertyIds' => $favoritePropertyIds,
            'filters' => $filters,
        ]);
    }
}
