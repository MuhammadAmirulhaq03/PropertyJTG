<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVisitSchedulesBufferTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdminAndAgent(): array
    {
        Carbon::setTestNow(Carbon::parse('2025-10-20 08:00:00'));
        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $agent = User::factory()->create(['role' => 'agen', 'status' => 'aktif']);
        return [$admin, $agent];
    }

    public function test_conflict_within_25_minute_buffer_returns_error(): void
    {
        [$admin, $agent] = $this->makeAdminAndAgent();

        // Existing 09:00–10:00
        VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-10-20 09:00:00'),
            'end_at' => Carbon::parse('2025-10-20 10:00:00'),
            'status' => 'available',
        ]);

        // New: 10:15–11:15 (within +25 buffer) → should error
        $resp = $this->actingAs($admin)->post(route('admin.visit-schedules.store'), [
            'agent_id' => $agent->id,
            'date' => '2025-10-20',
            'start_time' => '10:15',
            'end_time' => '11:15',
        ]);

        $resp->assertStatus(302)->assertSessionHasErrors('start_time');
    }

    public function test_outside_25_minute_buffer_is_allowed(): void
    {
        [$admin, $agent] = $this->makeAdminAndAgent();

        // Existing 09:00–10:00
        VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-10-20 09:00:00'),
            'end_at' => Carbon::parse('2025-10-20 10:00:00'),
            'status' => 'available',
        ]);

        // New: 10:26–11:26 (beyond +25 buffer) → should succeed
        $resp = $this->actingAs($admin)->post(route('admin.visit-schedules.store'), [
            'agent_id' => $agent->id,
            'date' => '2025-10-20',
            'start_time' => '10:26',
            'end_time' => '11:26',
            'location' => 'Site A',
        ]);

        $resp->assertRedirect(route('admin.visit-schedules.index', ['tab' => 'visit-schedules']));

        $this->assertDatabaseHas('visit_schedules', [
            'agent_id' => $agent->id,
            'start_at' => '2025-10-20 10:26:00',
            'end_at' => '2025-10-20 11:26:00',
            'status' => 'available',
        ]);
    }
}