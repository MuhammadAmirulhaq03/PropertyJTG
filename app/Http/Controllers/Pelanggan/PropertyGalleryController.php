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
        $properties = Properti::query()
            ->with(['media' => fn ($query) => $query->orderBy('is_primary', 'desc')->orderBy('sort_order')])
            ->where('status', 'published')
            ->orderByDesc('updated_at')
            ->get();

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
        ]);
    }
}
