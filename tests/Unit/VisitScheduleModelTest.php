<?php

namespace Tests\Unit;

use App\Models\VisitSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitScheduleModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_scope_available_returns_only_unbooked_available(): void
    {
        $agent = User::factory()->create(['role' => 'agen']);
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        $ok = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => now()->addHour(),
            'end_at' => now()->addHours(2),
            'status' => 'available',
            'customer_id' => null,
        ]);

        VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => now()->addHours(3),
            'end_at' => now()->addHours(4),
            'status' => 'booked',
            'customer_id' => $customer->id,
        ]);

        VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => now()->addHours(5),
            'end_at' => now()->addHours(6),
            'status' => 'closed',
        ]);

        $found = VisitSchedule::available()->get();
        $this->assertCount(1, $found);
        $this->assertTrue($found->first()->is($ok));
    }

    public function test_is_booked_flag(): void
    {
        $model = new VisitSchedule(['status' => 'booked', 'customer_id' => 123]);
        $this->assertTrue($model->isBooked());

        $model = new VisitSchedule(['status' => 'booked', 'customer_id' => null]);
        $this->assertFalse($model->isBooked());

        $model = new VisitSchedule(['status' => 'available', 'customer_id' => 123]);
        $this->assertFalse($model->isBooked());
    }

    public function test_duration_minutes_and_overlaps_with(): void
    {
        $schedule = new VisitSchedule([
            'start_at' => Carbon::parse('2025-10-20 09:00:00'),
            'end_at' => Carbon::parse('2025-10-20 10:00:00'),
        ]);

        $this->assertSame(60, abs($schedule->durationMinutes()));

        $empty = new VisitSchedule([]);
        $this->assertSame(0, $empty->durationMinutes());

        $this->assertTrue($schedule->overlapsWith(Carbon::parse('2025-10-20 09:30:00'), Carbon::parse('2025-10-20 10:30:00')));
        $this->assertFalse($schedule->overlapsWith(Carbon::parse('2025-10-20 10:00:00'), Carbon::parse('2025-10-20 11:00:00')));
        $this->assertFalse($schedule->overlapsWith(Carbon::parse('2025-10-20 08:00:00'), Carbon::parse('2025-10-20 09:00:00')));
    }

    public function test_duration_across_midnight_and_nested_overlaps(): void
    {
        $overnight = new VisitSchedule([
            'start_at' => Carbon::parse('2025-10-20 23:30:00'),
            'end_at' => Carbon::parse('2025-10-21 00:30:00'),
        ]);
        $this->assertSame(60, abs($overnight->durationMinutes()));

        $base = new VisitSchedule([
            'start_at' => Carbon::parse('2025-10-20 09:00:00'),
            'end_at' => Carbon::parse('2025-10-20 10:00:00'),
        ]);

        $this->assertTrue($base->overlapsWith(
            Carbon::parse('2025-10-20 09:15:00'),
            Carbon::parse('2025-10-20 09:45:00')
        ));

        $this->assertTrue($base->overlapsWith(
            Carbon::parse('2025-10-20 08:50:00'),
            Carbon::parse('2025-10-20 10:10:00')
        ));
    }
}