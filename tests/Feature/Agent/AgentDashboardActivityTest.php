<?php

use App\Models\DocumentUpload;
use App\Models\User;
use App\Models\VisitSchedule;

test('agent dashboard renders empty states without data', function () {
    $agent = User::factory()->create(['role' => 'agen']);

    $response = $this->actingAs($agent)->get(route('agent.dashboard'));

    $response->assertOk();
    $response->assertSee('No recent activity');
    $response->assertSee('No upcoming visits');
});

test('agent dashboard shows recent document review and booking activity', function () {
    $agent = User::factory()->create(['role' => 'agen']);

    // Document review activity
    DocumentUpload::create([
        'user_id' => User::factory()->create(['role' => 'customer'])->id,
        'document_type' => 'ktp_suami_istri',
        'original_name' => 'ktp.pdf',
        'file_path' => 'docs/ktp.pdf',
        'mime_type' => 'application/pdf',
        'file_size' => 1024,
        'status' => DocumentUpload::STATUS_APPROVED,
        'review_notes' => 'OK',
        'reviewed_by' => $agent->id,
        'reviewed_at' => now(),
    ]);

    // Recent booking activity in last 7 days
    $admin = User::factory()->create(['role' => 'admin']);
    VisitSchedule::create([
        'agent_id' => $agent->id,
        'admin_id' => $admin->id,
        'status' => 'booked',
        'customer_id' => User::factory()->create(['role' => 'customer'])->id,
        'location' => 'Show unit',
        'start_at' => now()->addDay(),
        'end_at' => now()->addDay()->addHour(),
        'booked_at' => now()->subHour(),
    ]);

    $response = $this->actingAs($agent)->get(route('agent.dashboard'));

    $response->assertOk();
    $response->assertSee('Reviewed');
    $response->assertSee('New visit booked');
});
