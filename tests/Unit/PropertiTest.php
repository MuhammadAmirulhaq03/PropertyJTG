<?php

namespace Tests\Unit;

use App\Models\Properti;
use Tests\TestCase;

class PropertiTest extends TestCase
{
    public function test_it_returns_primary_media_url_when_primary_relation_is_loaded(): void
    {
        $property = new Properti();
        $property->setRelation('primaryMedia', (object) [
            'url' => 'https://example.test/storage/properties/primary.jpg',
        ]);

        $this->assertSame(
            'https://example.test/storage/properties/primary.jpg',
            $property->primary_media_url
        );
    }

    public function test_it_falls_back_to_first_media_url_when_primary_is_missing(): void
    {
        $property = new Properti();
        $property->setRelation('media', collect([
            (object) [
                'url' => 'https://example.test/storage/properties/living-room.jpg',
                'sort_order' => 20,
            ],
            (object) [
                'url' => 'https://example.test/storage/properties/facade.jpg',
                'sort_order' => 10,
            ],
        ]));

        $this->assertSame(
            'https://example.test/storage/properties/facade.jpg',
            $property->primary_media_url
        );
    }

    public function test_it_returns_null_when_no_media_available(): void
    {
        $property = new Properti();
        $property->setRelation('media', collect());

        $this->assertNull($property->primary_media_url);
    }
}
