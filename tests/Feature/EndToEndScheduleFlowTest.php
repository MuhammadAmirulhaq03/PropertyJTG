<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EndToEndScheduleFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_creates_slot_customer_books_agent_sees_phone(): void
    {
        Carbon::setTestNow('2025-04-01 09:00:00');

        // Seed minimal users
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);

        $agent = User::factory()->create([
            'role' => 'agen',
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);

        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
            'must_change_password' => false,
            'phone' => '+62 812-1234-5678',
        ]);

        // Admin creates a future slot
        $this->actingAs($admin)
            ->post(route('admin.visit-schedules.store', ['tab' => 'visit-schedules']), [
                'agent_id' => $agent->id,
                'date' => Carbon::now()->toDateString(),
                'start_time' => '10:00',
                'end_time' => '10:45',
                'location' => 'Marketing Office',
                'notes' => 'E2E test slot',
            ])
            ->assertRedirect();

        $slot = VisitSchedule::first();
        $this->assertNotNull($slot);
        $this->assertEquals('available', $slot->status);

        // Customer sees the slot and books it
        $this->actingAs($customer)
            ->get(route('pelanggan.jadwal.index'))
            ->assertOk()
            ->assertSee('Marketing Office');

        $this->actingAs($customer)
            ->post(route('pelanggan.jadwal.book', $slot))
            ->assertRedirect(route('pelanggan.jadwal.index'))
            ->assertSessionHas('success');

        $slot->refresh();
        $this->assertEquals('booked', $slot->status);
        $this->assertEquals($customer->id, $slot->customer_id);

        // Agent dashboard shows customer's phone in upcoming schedule
        $this->actingAs($agent)
            ->get(route('agent.dashboard'))
            ->assertOk()
            ->assertSee('+62 812-1234-5678')
            ->assertSee('Marketing Office');
    }
}

