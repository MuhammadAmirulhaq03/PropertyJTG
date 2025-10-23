<?php

namespace Tests\Unit;

use App\Support\PropertyFilterService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class PropertyFilterServiceTest extends TestCase
{
    private PropertyFilterService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PropertyFilterService();
    }

    public function test_filters_by_location_and_type(): void
    {
        $properties = new Collection([
            ['title' => 'Cluster A', 'location' => 'Pekanbaru Timur', 'city' => 'Pekanbaru', 'type' => 'residensial', 'price' => 500_000_000],
            ['title' => 'Cluster B', 'location' => 'Medan', 'city' => 'Sumut', 'type' => 'komersial', 'price' => 600_000_000],
        ]);

        $filters = [
            'location' => 'pekanbaru',
            'type' => 'residensial',
        ];

        $result = $this->service->filter($properties, $filters);

        $this->assertCount(1, $result);
        $this->assertSame('Cluster A', $result->first()['title']);
    }

    public function test_filters_by_price_and_area_ranges(): void
    {
        $properties = new Collection([
            ['title' => 'Unit 1', 'price' => 400_000_000, 'land_area' => 72, 'building_area' => 36],
            ['title' => 'Unit 2', 'price' => 800_000_000, 'land_area' => 90, 'building_area' => 45],
            ['title' => 'Unit 3', 'price' => 600_000_000, 'land_area' => 0, 'building_area' => 42],
        ]);

        $filters = [
            'price_min' => 500_000_000,
            'price_max' => 900_000_000,
            'area_min' => 40,
            'area_max' => 80,
        ];

        $result = $this->service->filter($properties, $filters);

        $this->assertEquals(['title' => 'Unit 3', 'price' => 600_000_000, 'land_area' => 0, 'building_area' => 42], $result->first());
        $this->assertCount(1, $result);
    }

    public function test_filters_by_specifications_and_keywords(): void
    {
        $properties = new Collection([
            [
                'title' => 'Garden Home',
                'location' => 'Jakarta Selatan',
                'description' => 'Rumah dengan taman luas',
                'specs' => ['2 kamar tidur', 'garasi', 'taman'],
                'keywords' => ['strategis', 'investasi'],
                'price' => 700_000_000,
            ],
            [
                'title' => 'Urban Loft',
                'location' => 'Jakarta Barat',
                'description' => 'Apartemen modern',
                'specs' => ['studio', 'kolam renang'],
                'keywords' => ['premium'],
                'price' => 900_000_000,
            ],
        ]);

        $filters = [
            'specs' => 'garasi, taman',
            'keywords' => 'strategis',
        ];

        $result = $this->service->filter($properties, $filters);

        $this->assertCount(1, $result);
        $this->assertSame('Garden Home', $result->first()['title']);
    }
}
