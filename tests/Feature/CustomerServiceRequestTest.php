<?php

namespace Tests\Feature;

use App\Models\Consultant;
use App\Models\Contractor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerServiceRequestTest extends TestCase
{
    use RefreshDatabase;

    private function customer(): User
    {
        return User::factory()->create([
            'role' => 'customer',
        ]);
    }

    public function test_consultant_form_is_accessible_for_customer(): void
    {
        $user = $this->customer();

        $response = $this->actingAs($user)->get(route('pelanggan.consultants.create'));

        $response->assertStatus(200)->assertViewIs('pelanggan.consultants.create');
    }

    public function test_customer_can_submit_consultant_request(): void
    {
        $user = $this->customer();

        $payload = [
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '08123456789',
            'alamat' => 'Jl. Mawar No. 1',
            'spesialisasi' => 'KPR',
        ];

        $response = $this->actingAs($user)->post(route('pelanggan.consultants.store'), $payload);

        $response->assertRedirect(route('pelanggan.consultants.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('consultants', $payload);
    }

    public function test_contractor_form_is_accessible_for_customer(): void
    {
        $user = $this->customer();

        $response = $this->actingAs($user)->get(route('pelanggan.contractors.create'));

        $response->assertStatus(200)->assertViewIs('pelanggan.contractors.create');
    }

    public function test_customer_can_submit_contractor_request(): void
    {
        $user = $this->customer();

        $payload = [
            'nama' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '08129876543',
            'alamat' => 'Jl. Melati No. 2',
            'luas_bangunan_lahan' => '200 m2',
            'titik_lokasi' => 'Google Maps Link',
            'pesan' => 'Bangun rumah minimalis dua lantai.',
        ];

        $response = $this->actingAs($user)->post(route('pelanggan.contractors.store'), $payload);

        $response->assertRedirect(route('pelanggan.contractors.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contractors', $payload);
    }
}