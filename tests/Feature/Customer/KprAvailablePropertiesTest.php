<?php

use App\Models\Properti;
use App\Models\Admin;
use App\Models\User;

test('kpr calculator shows only published residential properties', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    // Admin owner for properties
    $adminUser = User::factory()->create(['role' => 'admin']);
    $admin = Admin::create(['user_id' => $adminUser->id]);

    // Published residential (should appear)
    Properti::create([
        'nama' => 'Cluster Sakura',
        'lokasi' => 'Pekanbaru',
        'tipe' => 'cluster',
        'tipe_properti' => 'residensial',
        'status' => 'published',
        'harga' => 500000000,
        'admin_id' => $admin->id,
    ]);

    // Published non-residential (should not appear)
    Properti::create([
        'nama' => 'Ruko Melati',
        'lokasi' => 'Pekanbaru',
        'tipe' => 'ruko',
        'tipe_properti' => 'komersial',
        'status' => 'published',
        'harga' => 800000000,
        'admin_id' => $admin->id,
    ]);

    // Draft residential (should not appear)
    Properti::create([
        'nama' => 'Cluster Anggrek',
        'lokasi' => 'Pekanbaru',
        'tipe' => 'cluster',
        'tipe_properti' => 'residensial',
        'status' => 'draft',
        'harga' => 450000000,
        'admin_id' => $admin->id,
    ]);

    $response = $this->actingAs($customer)->get(route('pelanggan.kpr.show'));

    $response->assertOk();
    $response->assertSee('Cluster Sakura');
    $response->assertDontSee('Ruko Melati');
    $response->assertDontSee('Cluster Anggrek');
});
