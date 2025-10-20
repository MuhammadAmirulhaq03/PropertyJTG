<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVisitSchedulesIndexTest extends TestCase
{
    use RefreshDatabase;

    private function seedSchedules(): array
    {
        Carbon::setTestNow(Carbon::parse('2025-10-20 09:00:00'));

        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $agentA = User::factory()->create(['role' => 'agen', 'status' => 'aktif']);
        $agentB = User::factory()->create(['role' => 'agen', 'status' => 'aktif']);

        // Yesterday (not upcoming)
        VisitSchedule::create([
            'agent_id' => $agentA->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-10-19 08:00:00'),
            'end_at' => Carbon::parse('2025-10-19 09:00:00'),
            'status' => 'closed',
        ]);

        // Today
        $todayAvail = VisitSchedule::create([
            'agent_id' => $agentA->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-10-20 10:00:00'),
            'end_at' => Carbon::parse('2025-10-20 11:00:00'),
            'status' => 'available',
        ]);
        $todayBooked = VisitSchedule::create([
            'agent_id' => $agentB->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-10-20 12:00:00'),
            'end_at' => Carbon::parse('2025-10-20 13:00:00'),
            'status' => 'booked',
            'customer_id' => User::factory()->create(['role' => 'customer'])->id,
        ]);

        // Tomorrow
        VisitSchedule::create([
            'agent_id' => $agentA->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-10-21 09:00:00'),
            'end_at' => Carbon::parse('2025-10-21 10:00:00'),
            'status' => 'available',
        ]);

        // Another booked today for agentA (to test status filter)
        VisitSchedule::create([
            'agent_id' => $agentA->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-10-20 15:00:00'),
            'end_at' => Carbon::parse('2025-10-20 16:00:00'),
            'status' => 'booked',
            'customer_id' => User::factory()->create(['role' => 'customer'])->id,
        ]);

        return [$admin, $agentA, $agentB, $todayAvail, $todayBooked];
    }

    public function test_filters_by_date_status_and_agent_and_stats_exist(): void
    {
        [$admin, $agentA, $agentB] = $this->seedSchedules();

        // 1) date filter: only schedules with start_at on 2025-10-20
        $respDate = $this->actingAs($admin)->get(route('admin.visit-schedules.index', [
            'date' => '2025-10-20',
        ]));
        $respDate->assertOk()->assertViewHas('schedules', function ($items) {
            return $items->every(fn ($s) => $s->start_at->isSameDay(Carbon::parse('2025-10-20')));
        });

        // 2) status filter: only booked
        $respStatus = $this->actingAs($admin)->get(route('admin.visit-schedules.index', [
            'status' => 'booked',
        ]));
        $respStatus->assertOk()->assertViewHas('schedules', function ($items) {
            return $items->every(fn ($s) => $s->status === 'booked');
        });

        // 3) agent filter: only agentA
        $respAgent = $this->actingAs($admin)->get(route('admin.visit-schedules.index', [
            'agent_id' => $agentA->id,
        ]));
        $respAgent->assertOk()->assertViewHas('schedules', function ($items) use ($agentA) {
            return $items->every(fn ($s) => $s->agent_id === $agentA->id);
        });

        // 4) stats presence with expected keys
        $respAll = $this->actingAs($admin)->get(route('admin.visit-schedules.index'));
        $respAll->assertOk()->assertViewHas('stats', function ($stats) {
            foreach (['total', 'upcoming', 'available', 'booked', 'closed'] as $key) {
                if (!array_key_exists($key, $stats)) return false;
            }
            return true;
        });
    }
}