<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVisitScheduleValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_create_slot_in_the_past(): void
    {
        Carbon::setTestNow('2025-02-10 10:30:00');

        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $agent = User::factory()->create([
            'role' => 'agen',
            'email_verified_at' => now(),
        ]);

        // Date is today, but start time is in the past (10:00 < 10:30)
        $response = $this->actingAs($admin)
            ->post(route('admin.visit-schedules.store', ['tab' => 'visit-schedules']), [
                'agent_id' => $agent->id,
                'date' => Carbon::now()->toDateString(),
                'start_time' => '10:00',
                'end_time' => '11:00',
                'location' => 'HQ',
                'notes' => 'Test',
            ]);

        $response->assertSessionHasErrors(['start_time']);
        $this->assertDatabaseCount('visit_schedules', 0);
    }

    public function test_admin_can_create_future_slot(): void
    {
        Carbon::setTestNow('2025-02-10 10:30:00');

        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $agent = User::factory()->create([
            'role' => 'agen',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.visit-schedules.store', ['tab' => 'visit-schedules']), [
                'agent_id' => $agent->id,
                'date' => Carbon::now()->toDateString(),
                'start_time' => '11:30',
                'end_time' => '12:30',
                'location' => 'HQ',
                'notes' => 'Future slot',
            ]);

        $response->assertSessionHasNoErrors()->assertRedirect();
        $this->assertDatabaseHas('visit_schedules', [
            'agent_id' => $agent->id,
            'location' => 'HQ',
        ]);
    }
}

