<?php

namespace Tests\Feature;

use App\Models\DocumentUpload;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerDocumentUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_upload_document_successfully(): void
    {
        Storage::fake('local');

        $user = User::factory()->create(['role' => 'customer']);

        $file = UploadedFile::fake()->image('slip.jpg')->size(500);

        $response = $this->actingAs($user)->post(route('documents.store'), [
            'document_type' => 'income_proof',
            'document' => $file,
        ]);

        $response->assertRedirect(route('documents.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('document_uploads', [
            'user_id' => $user->id,
            'document_type' => 'income_proof',
            'status' => DocumentUpload::STATUS_SUBMITTED,
            'original_name' => 'slip.jpg',
        ]);

        $doc = DocumentUpload::where('user_id', $user->id)
            ->where('document_type', 'income_proof')
            ->first();

        $this->assertNotNull($doc);
        $this->assertTrue(str_starts_with($doc->file_path, "documents/{$user->id}/income_proof/"));

        // Ensure the stored file exists on the fake disk
        $this->assertTrue(Storage::disk('local')->exists($doc->file_path));
        $this->assertGreaterThan(0, $doc->file_size);
    }
}