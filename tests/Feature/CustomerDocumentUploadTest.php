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

    public function test_replacing_existing_upload_deletes_old_and_updates_row(): void
    {
        Storage::fake('local');

        $user = User::factory()->create(['role' => 'customer']);
        $docType = 'income_proof';

        // Seed existing row + file
        $oldPath = "documents/{$user->id}/{$docType}/old-file.jpg";
        Storage::disk('local')->put($oldPath, 'old-content');

        $existing = DocumentUpload::create([
            'user_id' => $user->id,
            'document_type' => $docType,
            'original_name' => 'old-file.jpg',
            'file_path' => $oldPath,
            'mime_type' => 'image/jpeg',
            'file_size' => 1234,
            'status' => DocumentUpload::STATUS_SUBMITTED,
        ]);

        // Upload a new file; controller should delete old file and update row
        $newFile = UploadedFile::fake()->image('new-slip.jpg')->size(600);
        $response = $this->actingAs($user)->post(route('documents.store'), [
            'document_type' => $docType,
            'document' => $newFile,
        ]);

        $response->assertRedirect(route('documents.index'));

        $updated = DocumentUpload::where('id', $existing->id)->first();
        $this->assertNotNull($updated);
        $this->assertSame(DocumentUpload::STATUS_SUBMITTED, $updated->status);
        $this->assertSame('new-slip.jpg', $updated->original_name);
        $this->assertNotSame($oldPath, $updated->file_path);

        // Old file removed; new file exists
        $this->assertFalse(Storage::disk('local')->exists($oldPath));
        $this->assertTrue(Storage::disk('local')->exists($updated->file_path));
        $this->assertGreaterThan(0, $updated->file_size);
    }
}
