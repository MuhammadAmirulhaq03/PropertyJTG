<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DokumenControllerValidationTest extends TestCase
{
    use RefreshDatabase;

    private function actingCustomer(): User
    {
        return User::factory()->create(['role' => 'customer']);
    }

    public function test_document_type_required_and_must_be_allowed(): void
    {
        Storage::fake('local');
        $user = $this->actingCustomer();

        // Missing document_type
        $resp1 = $this->actingAs($user)->post(route('documents.store'), [
            'document' => UploadedFile::fake()->image('slip.jpg', 100, 100)->size(500),
        ]);
        $resp1->assertStatus(302)->assertSessionHasErrors('document_type');

        // Invalid document_type not in config('document-requirements')
        $resp2 = $this->actingAs($user)->post(route('documents.store'), [
            'document_type' => 'not_a_valid_key',
            'document' => UploadedFile::fake()->image('slip.jpg')->size(500),
        ]);
        $resp2->assertStatus(302)->assertSessionHasErrors('document_type');
    }

    public function test_document_mime_and_size_constraints(): void
    {
        Storage::fake('local');
        $user = $this->actingCustomer();

        // MIME invalid (PNG is not allowed, only PDF or JPEG)
        $respMime = $this->actingAs($user)->post(route('documents.store'), [
            'document_type' => 'ktp_suami_istri',
            'document' => UploadedFile::fake()->create('image.png', 200, 'image/png'),
        ]);
        $respMime->assertStatus(302)->assertSessionHasErrors('document');

        // Size too big (> 5120KB)
        $respSize = $this->actingAs($user)->post(route('documents.store'), [
            'document_type' => 'ktp_suami_istri',
            'document' => UploadedFile::fake()->create('big.pdf', 6000, 'application/pdf'),
        ]);
        $respSize->assertStatus(302)->assertSessionHasErrors('document');

        // Valid payload passes validation and redirects with status
        $respOk = $this->actingAs($user)->post(route('documents.store'), [
            'document_type' => 'ktp_suami_istri',
            'document' => UploadedFile::fake()->create('ok.jpg', 500, 'image/jpeg'),
        ]);
        $respOk->assertRedirect(route('documents.index'));
    }
}
