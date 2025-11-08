<?php

namespace Tests\Feature;

use App\Models\DocumentAccessRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentAccessGatingTest extends TestCase
{
    use RefreshDatabase;

    private function makeCustomer(): User
    {
        return User::factory()->create(['role' => 'customer']);
    }

    private function makeAgent(): User
    {
        return User::factory()->create(['role' => 'agen']);
    }

    public function test_upload_is_blocked_when_gated_and_no_approval(): void
    {
        config(['document-access.gated' => true]);
        Storage::fake('local');

        $customer = $this->makeCustomer();

        $resp = $this->actingAs($customer)->post(route('documents.store'), [
            'document_type' => 'ktp_suami_istri',
            'document' => UploadedFile::fake()->create('ktp.jpg', 300, 'image/jpeg'),
        ]);

        $resp->assertRedirect(route('documents.index'));
        $resp->assertSessionHasErrors('document');
    }

    public function test_upload_is_allowed_after_approval(): void
    {
        config(['document-access.gated' => true]);
        Storage::fake('local');

        $customer = $this->makeCustomer();
        $agent = $this->makeAgent();

        DocumentAccessRequest::create([
            'user_id' => $customer->id,
            'agent_id' => $agent->id,
            'status' => DocumentAccessRequest::STATUS_APPROVED,
            'requested_at' => now()->subHour(),
            'decided_at' => now()->subMinute(),
            'decided_by' => $agent->id,
        ]);

        $resp = $this->actingAs($customer)->post(route('documents.store'), [
            'document_type' => 'ktp_suami_istri',
            'document' => UploadedFile::fake()->create('ktp.jpg', 300, 'image/jpeg'),
        ]);

        $resp->assertRedirect(route('documents.index'));
        $resp->assertSessionHasNoErrors();
    }

    public function test_agent_cannot_approve_requests_not_assigned_to_them(): void
    {
        config(['document-access.gated' => true]);

        $agentA = $this->makeAgent();
        $agentB = $this->makeAgent();
        $agentA->forceFill(['email_verified_at' => now()])->save();
        $agentB->forceFill(['email_verified_at' => now()])->save();

        $customer = $this->makeCustomer();

        $docRequest = DocumentAccessRequest::create([
            'user_id' => $customer->id,
            'agent_id' => $agentA->id,
            'status' => DocumentAccessRequest::STATUS_REQUESTED,
            'requested_at' => now(),
        ]);

        // Wrong agent tries to approve -> 403
        $respForbidden = $this->actingAs($agentB)->post(route('agent.document-requests.approve', $docRequest));
        $respForbidden->assertStatus(403);
    }
}
