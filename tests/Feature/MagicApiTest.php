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
    public function testShowOrderForm() {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testShowOrder() {
        $order = Order::factory();

        $response = $this->get("/magic/{$order->id}");

        $response->assertStatus(200);
    }
}
