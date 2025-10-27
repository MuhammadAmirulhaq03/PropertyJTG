<?php

use App\Models\User;

test('document cards render Wajib and Opsional badges', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    $response = $this->actingAs($customer)->get(route('documents.index'));

    $response->assertOk();
    // Assert a couple of representative labels show their badges
    $response->assertSee('KTP Suami-Istri');
    $response->assertSee('Wajib');

    $response->assertSee('Buku Nikah');
    $response->assertSee('Opsional');
});

