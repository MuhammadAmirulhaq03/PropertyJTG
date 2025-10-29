<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitScheduleMaxAgentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_exceed_three_agents_in_same_slot(): void
    {
        Carbon::setTestNow('2025-05-01 08:00:00');

        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $agents = User::factory()->count(4)->create(['role' => 'agen', 'email_verified_at' => now()]);

        // Create three overlapping schedules (09:00-10:00) with three different agents
        foreach ($agents->take(3) as $agent) {
            VisitSchedule::create([
                'agent_id' => $agent->id,
                'admin_id' => $admin->id,
                'start_at' => Carbon::parse('2025-05-01 09:00:00'),
                'end_at' => Carbon::parse('2025-05-01 10:00:00'),
                'status' => 'available',
                'location' => 'Slot ' . $agent->id,
            ]);
        }

        // Attempt to create the 4th overlapping schedule at the same time with a different agent
        $fourthAgent = $agents[3];
        $this->actingAs($admin)
            ->post(route('admin.visit-schedules.store', ['tab' => 'visit-schedules']), [
                'agent_id' => $fourthAgent->id,
                'date' => '2025-05-01',
                'start_time' => '09:00',
                'end_time' => '10:00',
                'location' => 'Too many',
            ])
            ->assertSessionHasErrors(['start_time']);
    }
}

