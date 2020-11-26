<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MagicApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexRoute() {
        $controller = $this->getMock(MagicController::class);
        $controller
            ->expects($this->once())
            ->method('showOrderForm');
            // ->with('Post has been published');

        $response = $this->get('/');
    }

    public function testShowOrderRoute() {
        // $order = Order::factory();

        // $response = $this->get("/magic/{$order->id}");

        $response->assertStatus(200);
    }
}
