<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilePhoneUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_update_phone_and_agent_sees_it(): void
    {
        Carbon::setTestNow('2025-03-15 09:00:00');

        $customer = User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
            'phone' => null,
        ]);

        $agent = User::factory()->create([
            'role' => 'agen',
            'email_verified_at' => now(),
        ]);

        // Customer updates phone
        $this->actingAs($customer)
            ->patch(route('profile.update'), [
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => '+62 811-2222-333',
                'alamat' => 'Some address',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'phone' => '+62 811-2222-333',
        ]);

        // Create a future booked visit for this customer with the agent
        VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $agent->id,
            'start_at' => Carbon::now()->addHour(),
            'end_at' => Carbon::now()->addHours(2),
            'status' => 'booked',
            'customer_id' => $customer->id,
            'location' => 'Site A',
        ]);

        // Agent dashboard should show customer's phone number in upcoming schedule
        $this->actingAs($agent)
            ->get(route('agent.dashboard'))
            ->assertOk()
            ->assertSee('+62 811-2222-333');
    }
}

