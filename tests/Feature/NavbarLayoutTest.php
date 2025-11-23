<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavbarLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_sticky_navbar(): void
    {
        $this->get(route('homepage'))
            ->assertOk()
            ->assertSee('JAYA TIBAR GROUP')
            ->assertSee('Home Page');
    }
}
