<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Park;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_current_park_routes() {
        $response = $this->get('/park');
        $response = $this->get('/park/create');
        $response->assertStatus(200);
    }

    public function test_create_a_new_park_withoutcar() {
        $park = new Park(['ATP-34', 'Boston, L.Bird av. build, 34']);
        $this->assertEquals(['ATP-34', 'Boston, L.Bird av. build, 34'], $park->savePark());
    }
}
