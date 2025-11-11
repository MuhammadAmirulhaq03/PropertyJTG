<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class PasswordResetSafetyTest extends \Tests\TestCase
{
    use RefreshDatabase;

    public function test_unknown_email_does_not_send_notification(): void
    {
        Notification::fake();

        $response = $this->post('/forgot-password', ['email' => 'unknown@example.test']);

        $response->assertStatus(302)->assertSessionHasErrors('email');
        Notification::assertNothingSent();
    }

    public function test_cannot_reset_with_invalid_token_and_password_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/reset-password', [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'new-secure-password',
            'password_confirmation' => 'new-secure-password',
        ]);

        // Controller reports invalid token via 'email' error key
        $response->assertStatus(302)->assertSessionHasErrors('email');

        // Ensure original password remains intact (factory default is 'password')
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}

