<?php

use App\Models\DocumentUpload;
use App\Models\User;

test('customer document page shows agent notes for needs revision', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    DocumentUpload::create([
        'user_id' => $customer->id,
        'document_type' => 'ktp_suami_istri',
        'original_name' => 'ktp.pdf',
        'file_path' => 'docs/ktp.pdf',
        'mime_type' => 'application/pdf',
        'file_size' => 1000,
        'status' => DocumentUpload::STATUS_REVISION,
        'review_notes' => 'Mohon unggah ulang dengan foto lebih jelas.',
    ]);

    $response = $this->actingAs($customer)->get(route('documents.index'));
    $response->assertOk();
    $response->assertSee('Catatan dari agen');
    $response->assertSee('Mohon unggah ulang dengan foto lebih jelas.');
});

test('customer document page shows agent notes for rejected status', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    DocumentUpload::create([
        'user_id' => $customer->id,
        'document_type' => 'npwp',
        'original_name' => 'npwp.pdf',
        'file_path' => 'docs/npwp.pdf',
        'mime_type' => 'application/pdf',
        'file_size' => 1000,
        'status' => DocumentUpload::STATUS_REJECTED,
        'review_notes' => 'Dokumen tidak valid.',
    ]);

    $response = $this->actingAs($customer)->get(route('documents.index'));
    $response->assertOk();
    $response->assertSee('Catatan dari agen');
    $response->assertSee('Dokumen tidak valid.');
});

