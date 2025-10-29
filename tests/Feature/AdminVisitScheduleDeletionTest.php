<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVisitScheduleDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_available_schedule_but_not_booked(): void
    {
        Carbon::setTestNow('2025-06-01 10:00:00');

        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $agent = User::factory()->create(['role' => 'agen', 'email_verified_at' => now()]);
        $customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);

        $available = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::now()->addHour(),
            'end_at' => Carbon::now()->addHours(2),
            'status' => 'available',
            'location' => 'A',
        ]);

        $booked = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::now()->addHours(3),
            'end_at' => Carbon::now()->addHours(4),
            'status' => 'booked',
            'customer_id' => $customer->id,
            'location' => 'B',
        ]);

        // Delete available schedule
        $this->actingAs($admin)
            ->delete(route('admin.visit-schedules.destroy', $available))
            ->assertRedirect(route('admin.visit-schedules.index', ['tab' => 'visit-schedules']))
            ->assertSessionHas('success');
        $this->assertDatabaseMissing('visit_schedules', ['id' => $available->id]);

        // Attempt to delete booked schedule — should fail and still exist
        $this->actingAs($admin)
            ->delete(route('admin.visit-schedules.destroy', $booked))
            ->assertSessionHasErrors();
        $this->assertDatabaseHas('visit_schedules', ['id' => $booked->id]);
    }
}

