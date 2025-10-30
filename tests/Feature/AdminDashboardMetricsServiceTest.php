<?php

namespace Tests\Feature;

use App\Models\DocumentUpload;
use App\Models\Admin as AdminModel;
use App\Models\Customer as CustomerModel;
use App\Models\Feedback;
use App\Models\Properti;
use App\Models\User;
use App\Models\VisitSchedule;
use App\Services\Admin\DashboardMetricsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardMetricsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_metrics_returns_realistic_counts(): void
    {
        $service = app(DashboardMetricsService::class);

        // Users
        $admin = User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
        $agent = User::factory()->create(['role' => 'agen', 'email_verified_at' => now()]);
        $customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);

        // Domain admin/customer rows (FK targets for some tables)
        $adminRow = AdminModel::create(['user_id' => $admin->id]);
        $customerRow = CustomerModel::create(['user_id' => $customer->id]);

        // Listings
        $p1 = Properti::create([
            'nama' => 'Unit A',
            'lokasi' => 'Galeri',
            'harga' => 100000000,
            'tipe' => 'house',
            'status' => 'published',
            'spesifikasi' => 'spec',
            'deskripsi' => 'desc',
            'tipe_properti' => 'type',
            'admin_id' => $adminRow->id,
        ]);
        $p1->touch();

        // Future booked visit (counts as upcoming + enquiry)
        VisitSchedule::create([
            'agent_id' => $agent->id,
            'admin_id' => $admin->id,
            'customer_id' => $customer->id,
            'start_at' => now()->addDays(2),
            'end_at' => now()->addDays(2)->addHour(),
            'location' => 'Site',
            'status' => 'booked',
            'booked_at' => now()->subDay(),
        ]);

        // Document uploads (1 pending submitted, 1 claimed)
        DocumentUpload::create([
            'user_id' => $customer->id,
            'document_type' => 'ktp',
            'original_name' => 'ktp.pdf',
            'file_path' => 'docs/ktp.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 1234,
            'status' => DocumentUpload::STATUS_SUBMITTED,
            'review_notes' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);
        DocumentUpload::create([
            'user_id' => $customer->id,
            'document_type' => 'npwp',
            'original_name' => 'npwp.pdf',
            'file_path' => 'docs/npwp.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 2345,
            'status' => DocumentUpload::STATUS_APPROVED,
            'review_notes' => null,
            'reviewed_by' => $agent->id,
            'reviewed_at' => now()->subDay(),
        ]);

        // Feedback with rating
        Feedback::create([
            'rating' => 4,
            'mood' => 4,
            'komentar' => 'Good',
            'message' => 'Nice',
            'tanggal' => now()->toDateString(),
            'customer_id' => $customerRow->id,
            'admin_id' => $adminRow->id,
            'properti_id' => $p1->id,
        ]);

        $metrics = $service->metrics(30);

        $this->assertGreaterThanOrEqual(1, $metrics['active_listings']);
        $this->assertGreaterThanOrEqual(0, $metrics['updated_listings']);
        $this->assertGreaterThanOrEqual(1, $metrics['upcoming_visits']);
        $this->assertGreaterThanOrEqual(1, $metrics['new_enquiries']);
        $this->assertGreaterThanOrEqual(1, $metrics['pending_documents']);
        $this->assertGreaterThanOrEqual(1, $metrics['claimed_documents']);
        $this->assertGreaterThanOrEqual(0, $metrics['unclaimed_documents']);
        $this->assertGreaterThanOrEqual(1, $metrics['new_customers']);
        $this->assertIsInt($metrics['active_users']);
        $this->assertNotNull($metrics['avg_rating']);
    }
}
