<?php

namespace Tests\Feature;

use App\Models\Properti;
use App\Models\Admin as AdminModel;
use App\Models\PropertyFavorite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTrendFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_trend_favorites_sum_respects_filters(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        $adminRow = AdminModel::create(['user_id' => $admin->id]);

        $houseBandung = Properti::create([
            'nama' => 'House Bandung',
            'lokasi' => 'Bandung',
            'harga' => 150000000,
            'tipe' => 'house',
            'status' => 'published',
            'spesifikasi' => 'spec',
            'deskripsi' => 'desc',
            'tipe_properti' => null,
            'admin_id' => $adminRow->id,
        ]);

        $villaBali = Properti::create([
            'nama' => 'Villa Bali',
            'lokasi' => 'Bali',
            'harga' => 250000000,
            'tipe' => 'villa',
            'status' => 'published',
            'spesifikasi' => 'spec',
            'deskripsi' => 'desc',
            'tipe_properti' => null,
            'admin_id' => $adminRow->id,
        ]);

        // 3 favorites for Bandung house, 2 for Bali villa
        // Use different customers to satisfy unique (user_id, properti_id)
        $c2 = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        $c3 = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);

        PropertyFavorite::create(['user_id' => $customer->id, 'properti_id' => $houseBandung->id, 'created_at' => now(), 'updated_at' => now()]);
        PropertyFavorite::create(['user_id' => $c2->id, 'properti_id' => $houseBandung->id, 'created_at' => now(), 'updated_at' => now()]);
        PropertyFavorite::create(['user_id' => $c3->id, 'properti_id' => $houseBandung->id, 'created_at' => now(), 'updated_at' => now()]);

        $c4 = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        PropertyFavorite::create(['user_id' => $c2->id, 'properti_id' => $villaBali->id, 'created_at' => now(), 'updated_at' => now()]);
        PropertyFavorite::create(['user_id' => $c4->id, 'properti_id' => $villaBali->id, 'created_at' => now(), 'updated_at' => now()]);

        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard', ['range' => '30', 'type' => 'house', 'location' => 'bandung']))
            ->assertOk();

        $response->assertViewHas('trend', function ($trend) {
            if (!is_array($trend) || !isset($trend['views'])) return false;
            $sum = array_sum($trend['views']);
            // Only the 3 Bandung house favorites should be counted
            return $sum === 3;
        });
    }
}
