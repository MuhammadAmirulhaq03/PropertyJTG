<?php

namespace Tests\Unit;

use App\Models\DocumentUpload;
use Tests\TestCase;

class DocumentUploadTest extends TestCase
{
    public function test_status_labels_return_expected_map(): void
    {
        $labels = DocumentUpload::statusLabels();

        $this->assertSame('Submitted', $labels[DocumentUpload::STATUS_SUBMITTED] ?? null);
        $this->assertSame('Approved', $labels[DocumentUpload::STATUS_APPROVED] ?? null);
        $this->assertSame('Rejected', $labels[DocumentUpload::STATUS_REJECTED] ?? null);
        $this->assertSame('Needs Revision', $labels[DocumentUpload::STATUS_REVISION] ?? null);
    }

    public function test_status_badge_class_maps_correctly(): void
    {
        $approved = new DocumentUpload(['status' => DocumentUpload::STATUS_APPROVED]);
        $rejected = new DocumentUpload(['status' => DocumentUpload::STATUS_REJECTED]);
        $revision = new DocumentUpload(['status' => DocumentUpload::STATUS_REVISION]);
        $submitted = new DocumentUpload(['status' => DocumentUpload::STATUS_SUBMITTED]);

        $this->assertSame('bg-emerald-100 text-emerald-700', $approved->statusBadgeClass());
        $this->assertSame('bg-red-100 text-red-700', $rejected->statusBadgeClass());
        $this->assertSame('bg-amber-100 text-amber-700', $revision->statusBadgeClass());
        $this->assertSame('bg-slate-100 text-slate-600', $submitted->statusBadgeClass());
    }

    public function test_status_label_fallback_for_unknown_status(): void
    {
        $doc = new DocumentUpload(['status' => 'unknown_value']);

        // Fallback to the string used for submitted in statusLabels() when key not found
        $this->assertSame('Submitted', $doc->statusLabel());
    }
}