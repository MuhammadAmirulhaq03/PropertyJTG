<?php

namespace Tests\Feature;

use App\Models\Properti;
use App\Models\PropertiMedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPropertyMediaSyncTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'email_verified_at' => now()]);
    }

    public function test_store_creates_media_and_sets_primary(): void
    {
        Storage::fake('public');
        $admin = $this->makeAdmin();

        $resp = $this->actingAs($admin)->post(route('admin.properties.store'), [
            'nama' => 'Cluster Alpha',
            'lokasi' => 'City',
            'harga' => 750000000,
            'tipe' => 'primary',
            'status' => 'published',
            'tipe_properti' => 'residensial',
            'spesifikasi' => 'Specs here',
            'deskripsi' => 'Desc',
            'media' => [
                UploadedFile::fake()->image('a.jpg', 300, 300)->size(200),
                UploadedFile::fake()->image('b.jpg', 300, 300)->size(220),
            ],
            'media_caption' => ['Front', 'Living'],
            'featured_media' => 'new:1',
        ]);

        $resp->assertRedirect(route('admin.properties.index'));

        $property = Properti::latest('id')->first();
        $this->assertNotNull($property);
        $this->assertSame('Cluster Alpha', $property->nama);

        $media = $property->media()->get();
        $this->assertCount(2, $media);
        $this->assertTrue($media->contains(fn ($m) => $m->is_primary === true));
        foreach ($media as $m) {
            $this->assertTrue(Storage::disk('public')->exists($m->media_path));
        }
    }

    public function test_update_adds_removes_and_sets_primary(): void
    {
        Storage::fake('public');
        $admin = $this->makeAdmin();

        // Create initial property with one media via store
        $this->actingAs($admin)->post(route('admin.properties.store'), [
            'nama' => 'Beta',
            'lokasi' => 'City',
            'harga' => 500000000,
            'tipe' => 'primary',
            'status' => 'published',
            'tipe_properti' => 'residensial',
            'spesifikasi' => 'Specs',
            'deskripsi' => 'Desc',
            'media' => [UploadedFile::fake()->image('one.jpg')->size(180)],
            'media_caption' => ['One'],
            'featured_media' => 'new:0',
        ])->assertRedirect(route('admin.properties.index'));

        $property = Properti::latest('id')->first();
        $existing = $property->media()->first();
        Storage::disk('public')->put($existing->media_path, 'content'); // ensure exists
        $this->assertTrue(Storage::disk('public')->exists($existing->media_path));

        // Update: remove existing, add two new, set primary to the first new
        $resp = $this->actingAs($admin)->patch(route('admin.properties.update', $property), [
            'nama' => 'Beta Updated',
            'lokasi' => 'City',
            'harga' => 510000000,
            'tipe' => 'primary',
            'status' => 'published',
            'tipe_properti' => 'residensial',
            'spesifikasi' => 'Specs U',
            'deskripsi' => 'Desc U',
            'existing_media' => [
                $existing->id => ['caption' => 'Old cap', 'sort_order' => 0],
            ],
            'remove_media' => [$existing->id],
            'media' => [
                UploadedFile::fake()->image('new1.jpg')->size(200),
                UploadedFile::fake()->image('new2.jpg')->size(200),
            ],
            'media_caption' => ['N1', 'N2'],
            'featured_media' => 'new:0',
        ]);

        $resp->assertRedirect(route('admin.properties.index'));
        $property->refresh();

        $media = $property->media()->get();
        $this->assertCount(2, $media); // removed 1, added 2
        $this->assertDatabaseMissing('properti_media', ['id' => $existing->id]);
        $this->assertFalse(Storage::disk('public')->exists($existing->media_path));
        $this->assertTrue($media->contains(fn ($m) => $m->is_primary === true));
    }
}
