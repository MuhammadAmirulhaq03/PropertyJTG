<?php

namespace Tests\Feature;

use App\Models\Admin as AdminModel;
use App\Models\PropertyFavorite;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardLeadSourcesTest extends TestCase
{
    use RefreshDatabase;

    public function test_favorites_by_type_grouping_is_returned(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin', 'email_verified_at' => now(), 'must_change_password' => false]);
        $adminRow = AdminModel::create(['user_id' => $adminUser->id]);

        // Properties with various type fields
        $pHouse = Properti::create([
            'nama' => 'House A',
            'lokasi' => 'Loc 1',
            'harga' => 100000000,
            'tipe' => 'house',
            'status' => 'published',
            'spesifikasi' => 'spec',
            'deskripsi' => 'desc',
            'tipe_properti' => null,
            'admin_id' => $adminRow->id,
        ]);

        $pVilla = Properti::create([
            'nama' => 'Villa B',
            'lokasi' => 'Loc 2',
            'harga' => 200000000,
            'tipe' => 'villa',
            'status' => 'published',
            'spesifikasi' => 'spec',
            'deskripsi' => 'desc',
            'tipe_properti' => null,
            'admin_id' => $adminRow->id,
        ]);

        // Customers and favorites
        $c1 = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        $c2 = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        $c3 = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);

        // house -> 2 favorites
        PropertyFavorite::create(['user_id' => $c1->id, 'properti_id' => $pHouse->id]);
        PropertyFavorite::create(['user_id' => $c2->id, 'properti_id' => $pHouse->id]);
        // villa -> 1 favorite
        PropertyFavorite::create(['user_id' => $c3->id, 'properti_id' => $pVilla->id]);

        $response = $this->actingAs($adminUser)
            ->get(route('admin.dashboard', ['range' => '30']))
            ->assertOk();

        $response->assertViewHas('leadSources', function ($leadSources) {
            $labels = $leadSources['labels'] ?? [];
            $values = $leadSources['values'] ?? [];
            $map = [];
            foreach ($labels as $i => $label) {
                $map[$label] = $values[$i] ?? 0;
            }
            // Expect counts per type
            return ($map['house'] ?? 0) === 2
                && ($map['villa'] ?? 0) === 1;
        });
    }
}
