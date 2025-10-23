<?php

namespace Tests\Feature;

use Tests\TestCase;

class HouseViewTest extends TestCase
{
    public function test_house_view_page_renders_successfully(): void
    {
        $this->get(route('house-view'))
            ->assertOk()
            ->assertSee('House View')
            ->assertSee('District 1 Cluster')
            ->assertSee('Spesifikasi Teknis District 1');
    }

    public function test_house_view_displays_key_sections(): void
    {
        $response = $this->get(route('house-view'));

        $response
            ->assertSee('Design Highlights')
            ->assertSee('Konsep Tata Ruang')->assertSee('Visual')
            ->assertSee('Akses Strategis')->assertSee('Fasilitas Sekitar')
            ->assertSee('Lihat Listing Terbaru');
    }
}



