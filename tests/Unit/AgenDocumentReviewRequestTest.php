<?php

namespace Tests\Unit;

use App\Http\Requests\Agen\DocumentReviewRequest;
use App\Models\DocumentUpload;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request as BaseRequest;
use Tests\TestCase;

class AgenDocumentReviewRequestTest extends TestCase
{
    private function makeRequest(array $data, ?User $user = null): DocumentReviewRequest
    {
        $base = BaseRequest::create('/', 'PATCH', $data);
        /** @var DocumentReviewRequest $request */
        $request = DocumentReviewRequest::createFromBase($base);
        $request->setUserResolver(fn () => $user);
        return $request;
    }

    public function test_authorize_true_for_admin_and_agen_false_for_others(): void
    {
        $admin = User::factory()->make(['role' => 'admin']);
        $agent = User::factory()->make(['role' => 'agen']);
        $customer = User::factory()->make(['role' => 'customer']);

        $this->assertTrue($this->makeRequest([],$admin)->authorize());
        $this->assertTrue($this->makeRequest([],$agent)->authorize());
        $this->assertFalse($this->makeRequest([],$customer)->authorize());
        $this->assertFalse($this->makeRequest([])->authorize());
    }

    public function test_rules_validate_status_values(): void
    {
        $request = $this->makeRequest(['status' => 'invalid']);
        $validator = Validator::make($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('status', $validator->errors()->toArray());
    }

    public function test_review_notes_required_for_rejected_and_revision(): void
    {
        // Rejected without notes → fail
        $reqRejected = $this->makeRequest(['status' => DocumentUpload::STATUS_REJECTED]);
        $v1 = Validator::make($reqRejected->all(), $reqRejected->rules());
        $this->assertTrue($v1->fails());
        $this->assertArrayHasKey('review_notes', $v1->errors()->toArray());

        // Needs revision without notes → fail
        $reqRev = $this->makeRequest(['status' => DocumentUpload::STATUS_REVISION]);
        $v2 = Validator::make($reqRev->all(), $reqRev->rules());
        $this->assertTrue($v2->fails());
        $this->assertArrayHasKey('review_notes', $v2->errors()->toArray());

        // Rejected with notes → pass
        $reqRejectedOk = $this->makeRequest([
            'status' => DocumentUpload::STATUS_REJECTED,
            'review_notes' => 'Incomplete document',
        ]);
        $v3 = Validator::make($reqRejectedOk->all(), $reqRejectedOk->rules());
        $this->assertFalse($v3->fails());

        // Approved with no notes → pass
        $reqApproved = $this->makeRequest(['status' => DocumentUpload::STATUS_APPROVED]);
        $v4 = Validator::make($reqApproved->all(), $reqApproved->rules());
        $this->assertFalse($v4->fails());
    }
}