<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitScheduleVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_sees_only_future_available_slots(): void
    {
        Carbon::setTestNow('2025-01-01 10:00:00');

        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $agent = User::factory()->create([
            'role' => 'agen',
            'email_verified_at' => now(),
        ]);

        // Past slot (should be filtered out)
        VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $agent->id,
            'start_at' => Carbon::now()->subHour(),
            'end_at' => Carbon::now()->subMinutes(30),
            'status' => 'available',
            'location' => 'Past Slot',
        ]);

        // Future slot (should be visible)
        $future = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $agent->id,
            'start_at' => Carbon::now()->addHour(),
            'end_at' => Carbon::now()->addHours(2),
            'status' => 'available',
            'location' => 'Future Slot',
        ]);

        $this->actingAs($customer)
            ->get(route('pelanggan.jadwal.index'))
            ->assertOk()
            ->assertSee('Future Slot')
            ->assertDontSee('Past Slot');

        $this->assertDatabaseHas('visit_schedules', ['id' => $future->id]);
    }
}

