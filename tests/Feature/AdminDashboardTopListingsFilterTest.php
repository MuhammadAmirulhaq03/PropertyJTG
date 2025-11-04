<?php

namespace Tests\Feature;

use App\Models\Properti;
use App\Models\Admin as AdminModel;
use App\Models\PropertyFavorite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTopListingsFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_top_listings_respect_type_and_location_filters(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        $adminRow = AdminModel::create(['user_id' => $admin->id]);

        $houseBandung = Properti::create([
            'nama' => 'House A',
            'lokasi' => 'Bandung',
            'harga' => 100000000,
            'tipe' => 'house',
            'status' => 'published',
            'spesifikasi' => 'spec',
            'deskripsi' => 'desc',
            'tipe_properti' => null,
            'admin_id' => $adminRow->id,
        ]);

        $villaBali = Properti::create([
            'nama' => 'Villa B',
            'lokasi' => 'Bali',
            'harga' => 200000000,
            'tipe' => 'villa',
            'status' => 'published',
            'spesifikasi' => 'spec',
            'deskripsi' => 'desc',
            'tipe_properti' => null,
            'admin_id' => $adminRow->id,
        ]);

        // Favorites for both properties (unique per user/property)
        PropertyFavorite::create(['user_id' => $customer->id, 'properti_id' => $houseBandung->id]);
        $other = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        PropertyFavorite::create(['user_id' => $other->id, 'properti_id' => $villaBali->id]);

        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard', ['range' => '30', 'type' => 'house', 'location' => 'bandung']))
            ->assertOk();

        $response->assertViewHas('topListings', function ($listings) {
            // Expect only the Bandung house to be listed
            if (!is_array($listings) || count($listings) !== 1) return false;
            return ($listings[0]['name'] ?? null) === 'House A'
                && ($listings[0]['location'] ?? null) === 'Bandung';
        });
    }
}
