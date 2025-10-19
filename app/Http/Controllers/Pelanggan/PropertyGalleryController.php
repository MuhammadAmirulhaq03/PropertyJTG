<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Properti;
use Illuminate\View\View;

class PropertyGalleryController extends Controller
{
    public function index(): View
    {
        $properties = Properti::query()
            ->with(['media' => fn ($query) => $query->orderBy('is_primary', 'desc')->orderBy('sort_order')])
            ->where('status', 'published')
            ->orderByDesc('updated_at')
            ->get();

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
        ]);
    }
}
