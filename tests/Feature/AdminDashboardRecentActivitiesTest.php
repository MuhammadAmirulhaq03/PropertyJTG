<?php

namespace Tests\Feature;

use App\Models\Admin as AdminModel;
use App\Models\PropertyFavorite;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardRecentActivitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_activity_queries_for_registrations_and_favorites(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now(), 'must_change_password' => false]);
        $adminRow = AdminModel::create(['user_id' => $admin->id]);

        $customer = User::factory()->create(['role' => 'customer', 'name' => 'Customer Two', 'email_verified_at' => now(), 'must_change_password' => false]);

        $property = Properti::create([
            'nama' => 'Unit B',
            'lokasi' => 'Galeri',
            'harga' => 175000000,
            'tipe' => 'house',
            'status' => 'published',
            'spesifikasi' => 'spec',
            'deskripsi' => 'desc',
            'tipe_properti' => 'type',
            'admin_id' => $adminRow->id,
        ]);

        PropertyFavorite::create([
            'user_id' => $customer->id,
            'properti_id' => $property->id,
        ]);

        $from = now()->subDays(30);

        $registrations = User::query()
            ->where('role', 'customer')
            ->where('created_at', '>=', $from)
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(function ($u) {
                return [
                    'type' => 'user_registered',
                    'time' => $u->created_at,
                    'title' => 'New registration',
                    'description' => ($u->name ?: $u->email),
                ];
            });

        $favorites = PropertyFavorite::query()
            ->with(['user', 'property'])
            ->where('created_at', '>=', $from)
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(function ($fav) {
                $userName = optional($fav->user)->name ?: 'Customer';
                $propName = optional($fav->property)->nama ?: 'Property';
                return [
                    'type' => 'favorite',
                    'time' => $fav->created_at,
                    'title' => 'Property favorited',
                    'description' => $userName . ' → ' . $propName,
                ];
            });

        $this->assertNotEmpty($registrations);
        $this->assertNotEmpty($favorites);
    }
}

