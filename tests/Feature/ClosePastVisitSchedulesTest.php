<?php

namespace Tests\Feature;

use App\Console\Commands\ClosePastVisitSchedules;
use App\Models\VisitSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClosePastVisitSchedulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_marks_past_available_as_closed_and_past_booked_as_completed(): void
    {
        Carbon::setTestNow('2025-01-01 12:00:00');

        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now(), 'must_change_password' => false]);
        $agent = User::factory()->create(['role' => 'agen', 'email_verified_at' => now(), 'must_change_password' => false]);
        $customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now(), 'must_change_password' => false]);

        // Past available slot
        $pastAvailable = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::now()->subHours(2),
            'end_at' => Carbon::now()->subHour(),
            'location' => 'Past Available',
            'status' => 'available',
        ]);

        // Past booked slot
        $pastBooked = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'customer_id' => $customer->id,
            'start_at' => Carbon::now()->subHours(3),
            'end_at' => Carbon::now()->subHours(2),
            'location' => 'Past Booked',
            'status' => 'booked',
            'booked_at' => Carbon::now()->subHours(4),
        ]);

        // Future booked slot should not be touched
        $futureBooked = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'customer_id' => $customer->id,
            'start_at' => Carbon::now()->addHour(),
            'end_at' => Carbon::now()->addHours(2),
            'location' => 'Future Booked',
            'status' => 'booked',
            'booked_at' => Carbon::now(),
        ]);

        $this->artisan('visit-schedules:close-past')
            ->assertExitCode(ClosePastVisitSchedules::SUCCESS);

        $this->assertSame('closed', $pastAvailable->fresh()->status);
        $this->assertSame('completed', $pastBooked->fresh()->status);
        $this->assertSame('booked', $futureBooked->fresh()->status);
    }
}

