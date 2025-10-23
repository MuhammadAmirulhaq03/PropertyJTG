<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerBookingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_book_and_cancel_a_schedule(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-10-20 08:00:00'));

        $customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);
        $agent    = User::factory()->create(['role' => 'agen', 'status' => 'aktif']);
        $admin    = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);

        $slot = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-10-20 10:00:00'),
            'end_at' => Carbon::parse('2025-10-20 11:00:00'),
            'status' => 'available',
        ]);

        // Book
        $respBook = $this->actingAs($customer)->post(route('pelanggan.jadwal.book', $slot));
        $respBook->assertRedirect(route('pelanggan.jadwal.index'));

        $slot->refresh();
        $this->assertSame('booked', $slot->status);
        $this->assertSame($customer->id, $slot->customer_id);
        $this->assertNotNull($slot->booked_at);

        // Cancel
        $respCancel = $this->actingAs($customer)->delete(route('pelanggan.jadwal.cancel', $slot));
        $respCancel->assertRedirect(route('pelanggan.jadwal.index'));

        $slot->refresh();
        $this->assertSame('available', $slot->status);
        $this->assertNull($slot->customer_id);
        $this->assertNull($slot->booked_at);
    }

    public function test_cannot_cancel_schedule_not_owned(): void
    {
        Carbon::setTestNow(Carbon::parse('2025-10-20 08:00:00'));

        $owner = User::factory()->create(['role' => 'customer']);
        $other = User::factory()->create(['role' => 'customer']);
        $agent = User::factory()->create(['role' => 'agen', 'status' => 'aktif']);
        $admin = User::factory()->create(['role' => 'admin']);

        $slot = VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'start_at' => Carbon::parse('2025-10-20 10:00:00'),
            'end_at' => Carbon::parse('2025-10-20 11:00:00'),
            'status' => 'booked',
            'customer_id' => $owner->id,
            'booked_at' => now(),
        ]);

        $this->actingAs($other)->delete(route('pelanggan.jadwal.cancel', $slot))
            ->assertStatus(403);
    }
}
