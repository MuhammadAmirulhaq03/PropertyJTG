<?php

namespace Tests\Feature;

use App\Models\Agen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffAgentCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_agent_only_with_gmail(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Non-gmail should fail
        $this->actingAs($admin)
            ->post(route('admin.staff.agents.store'), [
                'name' => 'Agent One',
                'email' => 'agent1@example.com',
                'phone' => '0812',
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
            ])
            ->assertSessionHasErrors(['email']);

        // Gmail should pass and set must_change_password + agen profile
        $this->actingAs($admin)
            ->post(route('admin.staff.agents.store'), [
                'name' => 'Agent Two',
                'email' => 'agent.two@gmail.com',
                'phone' => '0813',
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $user = User::where('email', 'agent.two@gmail.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('agen', $user->role);
        $this->assertTrue((bool) ($user->must_change_password ?? false));
        $this->assertTrue(Agen::where('user_id', $user->id)->exists());
    }
}

