<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgentPresenceBadgeTest extends TestCase
{
    use RefreshDatabase;

    public function test_agents_page_shows_online_and_offline_badges(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);

        $online = User::factory()->create([
            'role' => 'agen',
            'name' => 'A Agent Online',
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);
        $online->forceFill(['last_seen_at' => now()])->save();

        $offline = User::factory()->create([
            'role' => 'agen',
            'name' => 'Z Agent Offline',
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);
        $offline->forceFill(['last_seen_at' => now()->subMinutes(10)])->save();

        $response = $this->actingAs($admin)->get(route('admin.staff.agents.index'));
        $response->assertOk();

        // Assert presence labels appear in expected order matching name sort
        $response->assertSeeTextInOrder([
            'A Agent Online',
            'Online',
            'Z Agent Offline',
            'Offline',
        ]);
    }
}

