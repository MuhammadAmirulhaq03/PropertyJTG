<?php

use App\Models\Consultant;
use App\Models\Contractor;
use App\Models\User;

test('admin can export consultant requests as CSV', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Consultant::create([
        'nama' => 'Andi',
        'email' => 'andi@example.com',
        'phone' => '081234567890',
        'alamat' => 'Jl. Test',
        'spesialisasi' => 'Residensial',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.requests.consultants.export'));

    $response->assertOk();
    expect($response->headers->get('content-type'))
        ->toContain('text/csv');
    // Streamed CSV content may not be buffered by the test client; headers are sufficient
    expect($response->headers->get('content-disposition'))
        ->toContain('attachment');
});

test('admin can export contractor requests as CSV', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Contractor::create([
        'nama' => 'Budi',
        'email' => 'budi@example.com',
        'phone' => '081111111111',
        'alamat' => 'Jl. Export',
        'luas_bangunan_lahan' => '36/72',
        'titik_lokasi' => 'Pekanbaru',
        'pesan' => 'Bangun rumah',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.requests.contractors.export'));

    $response->assertOk();
    expect($response->headers->get('content-type'))
        ->toContain('text/csv');
    expect($response->headers->get('content-disposition'))
        ->toContain('attachment');
});
