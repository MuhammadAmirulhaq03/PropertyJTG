<?php

namespace Tests\Feature;

use App\Models\DocumentAccessRequest;
use App\Models\User;
use App\Notifications\DocumentAccessRequestedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DocumentAccessNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_request_sends_notification_to_agent_and_blocks_duplicates(): void
    {
        config(['document-access.gated' => true]);

        Notification::fake();

        $customer = User::factory()->create(['role' => 'customer']);
        $agent = User::factory()->create(['role' => 'agen', 'email_verified_at' => now()]);

        // First request succeeds and notifies the agent
        $resp1 = $this->actingAs($customer)->post(route('documents.request.store'), [
            'agent_id' => $agent->id,
            'note' => 'Tolong tinjau segera.',
        ]);
        $resp1->assertRedirect(route('documents.index'));
        Notification::assertSentTo($agent, DocumentAccessRequestedNotification::class);

        $count = DocumentAccessRequest::where('user_id', $customer->id)->count();
        $this->assertSame(1, $count);

        // Second request should be blocked (duplicate active request)
        $resp2 = $this->actingAs($customer)->post(route('documents.request.store'), [
            'agent_id' => $agent->id,
            'note' => 'duplikat',
        ]);
        $resp2->assertRedirect(route('documents.index'));
        $resp2->assertSessionHasErrors();

        $countAfter = DocumentAccessRequest::where('user_id', $customer->id)->count();
        $this->assertSame(1, $countAfter);
    }
}

