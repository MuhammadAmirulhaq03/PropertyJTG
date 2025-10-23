<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Properti;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless($user && $user->hasRole('customer'), 403);

        $favorites = $user->favoriteProperties()
            ->with(['primaryMedia'])
            ->orderByDesc('property_favorites.created_at')
            ->get();

        $types = [
            'residensial' => 'Residensial',
            'komersial' => 'Komersial',
            'apartemen' => 'Apartemen',
            'tanah' => 'Tanah Kosong',
            'lainnya' => 'Lainnya',
        ];

        return view('pelanggan.favorit.index', [
            'favorites' => $favorites,
            'types' => $types,
        ]);
    }

    public function store(Request $request, Properti $property): JsonResponse
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole('customer')) {
            return response()->json([
                'status' => 'error',
                'message' => __('Silakan masuk sebagai pelanggan untuk menyimpan favorit.'),
            ], 403);
        }

        $user->favoriteProperties()->syncWithoutDetaching([$property->id]);

        return response()->json([
            'status' => 'saved',
            'message' => __('Properti ditambahkan ke favorit Anda.'),
        ]);
    }

    public function destroy(Request $request, Properti $property): JsonResponse
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole('customer')) {
            return response()->json([
                'status' => 'error',
                'message' => __('Silakan masuk sebagai pelanggan untuk menghapus favorit.'),
            ], 403);
        }

        $user->favoriteProperties()->detach($property->id);

        return response()->json([
            'status' => 'removed',
            'message' => __('Properti dihapus dari favorit Anda.'),
        ]);
    }
}
