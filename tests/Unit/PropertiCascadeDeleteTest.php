<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\Properti;
use App\Models\PropertiMedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertiCascadeDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_media_removes_file_from_disk(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $admin = Admin::create(['user_id' => $user->id]);
        $property = Properti::create([
            'nama' => 'Temp',
            'lokasi' => 'X',
            'harga' => 1,
            'tipe' => 'primary',
            'status' => 'published',
            'tipe_properti' => 'residensial',
            'admin_id' => $admin->id,
        ]);

        $media = PropertiMedia::create([
            'properti_id' => $property->id,
            'disk' => 'public',
            'media_path' => 'properties/photos/test.jpg',
            'media_type' => 'image',
            'filesize' => 123,
        ]);

        Storage::disk('public')->put($media->media_path, 'img');
        $this->assertTrue(Storage::disk('public')->exists($media->media_path));

        $media->delete();
        $this->assertFalse(Storage::disk('public')->exists('properties/photos/test.jpg'));
    }

    public function test_deleting_property_cascades_to_media_and_deletes_file(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $admin = Admin::create(['user_id' => $user->id]);

        $property = Properti::create([
            'nama' => 'Unit X',
            'lokasi' => 'Somewhere',
            'harga' => 1000000,
            'tipe' => 'primary',
            'status' => 'published',
            'tipe_properti' => 'residensial',
            'admin_id' => $admin->id,
        ]);

        $media = $property->media()->create([
            'disk' => 'public',
            'media_path' => 'properties/photos/x.jpg',
            'media_type' => 'image',
            'filesize' => 10,
        ]);

        Storage::disk('public')->put('properties/photos/x.jpg', 'imgx');
        $this->assertTrue(Storage::disk('public')->exists('properties/photos/x.jpg'));

        $property->delete();

        $this->assertDatabaseMissing('properti_media', ['id' => $media->id]);
        $this->assertFalse(Storage::disk('public')->exists('properties/photos/x.jpg'));
    }
}
