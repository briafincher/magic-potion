<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\MagicController;
use App\Models\Order;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;

class MagicControllerTest extends TestCase
{
	use RefreshDatabase;

   	// Tests for showOrderForm()
    public function test_show_order_form_returns_app_view() {
    	$response = (new MagicController)->showOrderForm();
    	$view_name = $response->name();

    	$this->assertSame($view_name, 'app');
    }	

    // Tests for createOrder()
    public function testCreateOrder() {

    }

    // Tests for showOrder()
    public function test_show_order_returns_order_details_when_it_exists() {
        $order = Order::factory()->create();
        $user = $order->user;
        $address = $order->address;
        $payment_method = $order->payment_method;

        $response = (new MagicController)->showOrder($order->id);

        $this->assertSame($response->status(), 200);
        $this->assertSame($response->getContent(), json_encode([
            'firstName' => $user->first_name, 
            'lastName' => $user->last_name, 
            'email' => $user->email, 
            'address' => [
                'street1' => $address->street_1, 
                'street2' => $address->street_2, 
                'city' => $address->city, 
                'state' => $address->state, 
                'zip' => $address->zip,
            ],
            'phone' => $user->phone_number, 
            'payment' => [
                'ccNum' => $payment_method->card_number,
                'exp' => $payment_method->card_number, 
            ],
            'quantity' => $order->quantity, 
            'total' => $order->total(),
             'orderDate' => $order->created_at, 
             'fulfilled' => $order->fulfilled
        ]));
    }

    public function test_show_order_returns_404_when_order_does_not_exist() {
    	$order = Order::factory()->create();
    	$order->delete();

        $response = (new MagicController)->showOrder($order->id);

        $this->assertSame($response->status(), 404);
    }

    // Tests for updateOrder()
    public function test_update_order_updates_fulfilled_column_when_order_exists() {
    	$order = Order::factory()->create();
    	$this->assertSame($order->fulfilled, false);

    	$request = Request::create('/updateOrder', 'PATCH', [
    		'id' => $order->id,
    		'fulfilled' => true
    	]);

    	$response = (new MagicController)->updateOrder($request);

    	$this->assertSame($response->status(), 200);
    	$this->assertSame($order->refresh()->fulfilled, true);
    }

    public function test_update_order_returns_404_when_order_does_not_exist() {
    	$order = Order::factory()->create();
    	$order->delete();

    	$request = Request::create('/updateOrder', 'PATCH', [
    		'id' => $order->id,
    		'fulfilled' => true
    	]);

    	$response = (new MagicController)->updateOrder($request);

    	$this->assertSame($response->status(), 404);
    }

    // Tests for deleteOrder()
    public function test_delete_order_destroys_order_when_it_exists() {
    	$order = Order::factory()->create();
    	$response = (new MagicController)->deleteOrder($order->id);

    	$this->assertSame($response->status(), 200);
    	$this->assertDeleted($order);
    }

    public function test_delete_order_returns_404_when_order_does_not_exist() {
    	$order = Order::factory()->create();
    	$order->delete();

    	$response = (new MagicController)->deleteOrder($order->id);

    	$this->assertSame($response->status(), 404);
    }
}

