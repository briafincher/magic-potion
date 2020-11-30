<?php

namespace Tests\Unit;

use App\Http\Controllers\MagicController;

use Tests\TestCase;

class ApiTest extends TestCase
{
    // Tests for Magic API routes
    public function test_show_order_form_route() {
        // {
        //     Auth::shouldReceive('check')->once()->andReturn(false);

        //     $response = $this->call('GET', 'home');
            
        //     // Now we have several ways to go about this, choose the
        //     // one you're most comfortable with.

        //     // Check that you're redirecting to a specific controller action 
        //     // with a flash message
        //     $this->assertRedirectedToAction(
        //          'AuthenticationController@login', 
        //          null, 
        //          ['flash_message']
        //     );
            
        //     // Only check that you're redirecting to a specific URI
        //     $this->assertRedirectedTo('login');

        //     // Just check that you don't get a 200 OK response.
        //     $this->assertFalse($response->isOk());

        //     // Make sure you've been redirected.
        //     $this->assertTrue($response->isRedirection());
        // }

        $controller = $this->createMock(MagicController::class);
        $controller
            ->expects($this->once())
            ->method('showOrderForm');

        $response = $this->get('/');
    }

    public function test_create_order_route() {
        $controller = $this->createMock(MagicController::class);
        $controller
            ->expects($this->once())
            ->method('createOrder');
            // ->with('Post has been published');

        $response = $this->post('/magic');
    }

    public function test_show_order_route() {
        $controller = $this->createMock(MagicController::class);
        $controller
            ->expects($this->once())
            ->method('showOrder');

        $response = $this->get('/magic/1');
    }

    public function test_update_order_route() {
        // $controller = $this->createMock(MagicController::class);
        // $controller
        //     ->expects($this->once())
        //     ->method('updateOrder');
            // ->with('Post has been published');

        $this->mock(MagicController::class, function ($mock) {
            $mock->shouldReceive('updateOrder')->once();
        });

        $response = $this->patch('/magic');
    }

    public function test_delete_order_route() {
        $controller = $this->createMock(MagicController::class);
        $controller
            ->expects($this->once())
            ->method('deleteOrder');

        // $this->spy(Service::class, function ($mock) {
        //     $mock->shouldHaveReceived('process');
        // });

        $response = $this->delete('/magic/1');
    }
}
