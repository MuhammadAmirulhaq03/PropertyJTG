<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitScheduleConstraintsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_create_overlapping_slot_within_buffer(): void
    {
        Carbon::setTestNow('2025-04-10 08:00:00');

        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $agent = User::factory()->create(['role' => 'agen', 'email_verified_at' => now()]);

        // Existing slot 09:00-10:00
        VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-04-10 09:00:00'),
            'end_at' => Carbon::parse('2025-04-10 10:00:00'),
            'status' => 'available',
        ]);

        // Try to create a slot inside the 25-minute buffer (09:20-09:50)
        $this->actingAs($admin)
            ->post(route('admin.visit-schedules.store', ['tab' => 'visit-schedules']), [
                'agent_id' => $agent->id,
                'date' => '2025-04-10',
                'start_time' => '09:20',
                'end_time' => '09:50',
                'location' => 'Overlap Test',
            ])
            ->assertSessionHasErrors(['start_time']);
    }

    public function test_admin_cannot_change_time_of_booked_schedule(): void
    {
        Carbon::setTestNow('2025-04-10 08:00:00');

        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $agent = User::factory()->create(['role' => 'agen', 'email_verified_at' => now()]);
        $customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);

        $schedule = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-04-10 10:00:00'),
            'end_at' => Carbon::parse('2025-04-10 11:00:00'),
            'status' => 'booked',
            'customer_id' => $customer->id,
        ]);

        // Attempt to move booked slot to a new time
        $this->actingAs($admin)
            ->put(route('admin.visit-schedules.update', $schedule), [
                'agent_id' => $agent->id,
                'date' => '2025-04-10',
                'start_time' => '12:00',
                'end_time' => '13:00',
                'location' => 'Updated',
                'notes' => 'Try update',
            ])
            ->assertSessionHasErrors();

        $schedule->refresh();
        $this->assertEquals('10:00:00', $schedule->start_at->format('H:i:s'));
        $this->assertEquals('11:00:00', $schedule->end_at->format('H:i:s'));
    }
}

