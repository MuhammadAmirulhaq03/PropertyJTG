<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_page_renders(): void
    {
        $this->get(route('gallery.index'))
            ->assertOk()
            ->assertSee('Galeri Properti & Filosofi Kami');
    }

    public function test_gallery_page_contains_property_section_heading(): void
    {
        $response = $this->get(route('gallery.index'));
        $response->assertSee('Koleksi Properti Terbaru');
    }
}