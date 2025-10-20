<?php

namespace Tests\Unit;

use App\Models\PropertiMedia;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PropertiMediaTest extends TestCase
{
    public function test_it_returns_storage_url_when_file_exists(): void
    {
        Storage::fake('public');

        $path = 'properties/photos/sample.jpg';
        Storage::disk('public')->put($path, 'fake-image');

        $media = new PropertiMedia([
            'disk' => 'public',
            'media_path' => $path,
        ]);

        $this->assertSame(
            Storage::disk('public')->url($path),
            $media->url
        );
    }

    public function test_it_falls_back_to_asset_when_file_is_missing(): void
    {
        Storage::fake('public');
        Config::set('app.url', 'http://propertyjtg.test');

        $path = 'properties/photos/missing.jpg';

        $media = new PropertiMedia([
            'disk' => 'public',
            'media_path' => $path,
        ]);

        $this->assertSame(
            asset('storage/'.$path),
            $media->url
        );
    }

    public function test_it_returns_empty_string_when_media_path_is_empty(): void
    {
        $media = new PropertiMedia([
            'disk' => 'public',
            'media_path' => null,
        ]);

        $this->assertSame('', $media->url);
    }
}
