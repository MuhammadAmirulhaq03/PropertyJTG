<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MustChangePasswordMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_agent_with_must_change_password_is_redirected_to_profile(): void
    {
        $agent = User::factory()->create([
            'role' => 'agen',
            'email_verified_at' => now(),
            'must_change_password' => true,
        ]);

        $this->actingAs($agent)
            ->get(route('agent.dashboard'))
            ->assertRedirect(route('profile.edit'));
    }
}

