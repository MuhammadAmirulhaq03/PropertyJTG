<?php

namespace Tests\Feature;

use App\Models\DocumentUpload;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentClaimReleaseTest extends TestCase
{
    use RefreshDatabase;

    private function makeCustomer(): User
    {
        return User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);
    }

    private function makeAgent(string $email = 'agent@example.com'): User
    {
        return User::factory()->create([
            'role' => 'agen',
            'email' => $email,
            'email_verified_at' => now(),
            'must_change_password' => false,
        ]);
    }

    private function makeDoc(User $customer): DocumentUpload
    {
        return DocumentUpload::create([
            'user_id' => $customer->id,
            'document_type' => 'test_doc',
            'original_name' => 'dummy.pdf',
            'file_path' => 'documents/'.$customer->id.'/test_doc/dummy.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 1234,
            'status' => DocumentUpload::STATUS_SUBMITTED,
        ]);
    }

    public function test_first_agent_can_claim_document(): void
    {
        $customer = $this->makeCustomer();
        $doc = $this->makeDoc($customer);
        $agent = $this->makeAgent('agent1@gmail.com');

        $this->actingAs($agent)
            ->post(route('agent.documents.claim', $doc))
            ->assertSessionHas('status');

        $doc->refresh();
        $this->assertEquals($agent->id, $doc->reviewed_by);
        $this->assertNotNull($doc->reviewed_at);
    }

    public function test_second_agent_cannot_claim_already_claimed_document(): void
    {
        $customer = $this->makeCustomer();
        $doc = $this->makeDoc($customer);
        $agent1 = $this->makeAgent('a1@gmail.com');
        $agent2 = $this->makeAgent('a2@gmail.com');

        $this->actingAs($agent1)->post(route('agent.documents.claim', $doc));

        $this->actingAs($agent2)
            ->post(route('agent.documents.claim', $doc))
            ->assertSessionHasErrors();

        $doc->refresh();
        $this->assertEquals($agent1->id, $doc->reviewed_by);
    }

    public function test_only_reviewer_can_release(): void
    {
        $customer = $this->makeCustomer();
        $doc = $this->makeDoc($customer);
        $agent1 = $this->makeAgent('a1@gmail.com');
        $agent2 = $this->makeAgent('a2@gmail.com');

        $this->actingAs($agent1)->post(route('agent.documents.claim', $doc));

        // Non-reviewer cannot release
        $this->actingAs($agent2)
            ->post(route('agent.documents.release', $doc))
            ->assertSessionHasErrors();
        $doc->refresh();
        $this->assertEquals($agent1->id, $doc->reviewed_by);

        // Reviewer can release
        $this->actingAs($agent1)
            ->post(route('agent.documents.release', $doc))
            ->assertSessionHas('status');
        $doc->refresh();
        $this->assertNull($doc->reviewed_by);
    }
}

