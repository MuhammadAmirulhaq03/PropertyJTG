<?php

use App\Models\DocumentUpload;
use App\Models\User;

function makeDoc(User $user, string $type): DocumentUpload
{
    return DocumentUpload::create([
        'user_id' => $user->id,
        'document_type' => $type,
        'original_name' => $type . '.pdf',
        'file_path' => 'docs/' . $type . '.pdf',
        'mime_type' => 'application/pdf',
        'file_size' => 1024,
        'status' => DocumentUpload::STATUS_SUBMITTED,
    ]);
}

test('agent can filter customers by required documents', function () {
    $agent = User::factory()->create(['role' => 'agen']);
    $customerRequired = User::factory()->create(['role' => 'customer']);
    $customerOptional = User::factory()->create(['role' => 'customer']);

    // One customer has a required doc, the other only optional
    makeDoc($customerRequired, 'ktp_suami_istri'); // required
    makeDoc($customerOptional, 'buku_nikah'); // optional

    $response = $this->actingAs($agent)->get(route('agent.documents.index', [
        'requirement' => 'required',
    ]));

    $response->assertOk();
    $response->assertSee($customerRequired->name);
    $response->assertDontSee($customerOptional->name);

    // Document type dropdown should exclude optional types when filtering required
    $response->assertSee('KTP Suami-Istri');
    $response->assertDontSee('Buku Nikah');
});

test('agent can filter customers by optional documents', function () {
    $agent = User::factory()->create(['role' => 'agen']);
    $customerRequired = User::factory()->create(['role' => 'customer']);
    $customerOptional = User::factory()->create(['role' => 'customer']);

    makeDoc($customerRequired, 'ktp_suami_istri'); // required
    makeDoc($customerOptional, 'buku_nikah'); // optional

    $response = $this->actingAs($agent)->get(route('agent.documents.index', [
        'requirement' => 'optional',
    ]));

    $response->assertOk();
    $response->assertSee($customerOptional->name);
    $response->assertDontSee($customerRequired->name);

    // Document type dropdown should exclude required types when filtering optional
    $response->assertSee('Buku Nikah');
    $response->assertDontSee('KTP Suami-Istri');
});

