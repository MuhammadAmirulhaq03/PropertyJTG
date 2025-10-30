<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolesAccessSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_open_visit_schedule_page(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);

        $this->actingAs($customer)
            ->get(route('pelanggan.jadwal.index'))
            ->assertOk();
    }

    public function test_agent_can_open_agent_dashboard(): void
    {
        $agent = User::factory()->create([
            'role' => 'agen',
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);

        $this->actingAs($agent)
            ->get(route('agent.dashboard'))
            ->assertOk();
    }

    public function test_admin_can_open_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }
}

