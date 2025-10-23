<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Properti;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerFavoritesTest extends TestCase
{
    use RefreshDatabase;

    private function createProperty(): Properti
    {
        $adminUser = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $admin = Admin::create(['user_id' => $adminUser->id]);

        return Properti::create([
            'nama' => 'Cluster Favorit',
            'lokasi' => 'Pekanbaru',
            'harga' => 750_000_000,
            'tipe' => 'primary',
            'status' => 'published',
            'tipe_properti' => 'residensial',
            'spesifikasi' => '2 Kamar Tidur, 1 Kamar Mandi',
            'deskripsi' => 'Hunian nyaman dengan akses utama kota.',
            'admin_id' => $admin->id,
        ]);
    }

    public function test_customer_can_add_and_remove_favorite(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
        $property = $this->createProperty();

        $store = $this->actingAs($customer)->postJson(route('pelanggan.favorites.store', $property));
        $store->assertSuccessful()->assertJson(['status' => 'saved']);

        $this->assertDatabaseHas('property_favorites', [
            'user_id' => $customer->id,
            'properti_id' => $property->id,
        ]);

        $destroy = $this->actingAs($customer)->deleteJson(route('pelanggan.favorites.destroy', $property));
        $destroy->assertSuccessful()->assertJson(['status' => 'removed']);

        $this->assertDatabaseMissing('property_favorites', [
            'user_id' => $customer->id,
            'properti_id' => $property->id,
        ]);
    }

    public function test_index_lists_favorited_properties(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);
        $property = $this->createProperty();

        $customer->favoriteProperties()->sync([$property->id]);

        $response = $this->actingAs($customer)->get(route('pelanggan.favorit.index'));

        $response->assertOk();
        $response->assertSeeText($property->nama);
    }

    public function test_non_customer_cannot_favorite_property(): void
    {
        $agent = User::factory()->create([
            'role' => 'agen',
        ]);
        $property = $this->createProperty();

        $this->actingAs($agent)
            ->postJson(route('pelanggan.favorites.store', $property))
            ->assertForbidden();
    }
}
