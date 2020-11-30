<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\MagicController;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\PaymentMethod;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;

class MagicControllerTest extends TestCase
{
	use RefreshDatabase;

	private $order_details = [
		'firstName' => 'Jurgen', 
		'lastName' => 'Klopp', 
		'email' => 'jurgen@liverpoolfc.com', 
		'address' => [
			'street1' => '1 Anfield Road', 
			'street2' => 'Suite 6', 
			'city' => 'Liverpool', 
			'state' => 'UK', 
			'zip' => '12345'
		],
		'phone' => '1234567890', 
		'quantity' => 2, 
		'total' => 2 * 49.99, 
		'payment' => [
			'ccNum' => '123',
			'exp' => '456' 
		]
	];

   	// Tests for showOrderForm()
    public function test_show_order_form_returns_app_view() {
    	$response = (new MagicController)->showOrderForm();
    	$view_name = $response->name();

    	$this->assertSame($view_name, 'app');
    }	

    // Tests for createOrder()
    public function test_create_order_returns_user_details() {
    	$request = Request::create('/createOrder', 'POST', $this->order_details);
    	$response = (new MagicController)->createOrder($request);

    	$this->assertSame($response->status(), 201);
    	$this->assertSame($response->getContent(), json_encode([
    		'id' => User::all()->last()->id
    	]));
    }

    // Should this be a 500 error?
    public function test_create_order_returns_500_if_there_is_an_error_creating_the_order() {
    	// TODO: Fill me in!!
    }

    public function test_create_order_adds_user_if_not_in_db() {
    	$this->assertSame(User::count(), 0);

    	$request = Request::create('/createOrder', 'POST', $this->order_details);
    	$response = (new MagicController)->createOrder($request);

    	$this->assertSame(User::count(), 1);
    }

    public function test_create_order_gets_user_from_db_if_exists() {
    	$user = User::factory()->create();

    	$this->assertSame(User::count(), 1);

    	$this->order_details['firstName'] = $user->first_name;
    	$this->order_details['lastName'] = $user->last_name;
    	$this->order_details['email'] = $user->email;
    	$this->order_details['phone'] = $user->phone;

    	$request = Request::create('/createOrder', 'POST', $this->order_details);
    	$response = (new MagicController)->createOrder($request);

    	$created_order = Order::all()->last();

    	$this->assertSame(User::count(), 1);
    	$this->assertSame($created_order->user_id, $user->id);
   	}

    public function test_create_order_adds_address_if_not_in_db() {
    	$this->assertSame(Address::count(), 0);

    	$request = Request::create('/createOrder', 'POST', $this->order_details);
    	$response = (new MagicController)->createOrder($request);

    	$this->assertSame(Address::count(), 1);
    }

    public function test_create_order_gets_address_from_db_if_it_exists_for_user() {
    	$user = User::factory()->create();
    	$address = Address::factory()->create();
    	$user->address()->save($address);

    	$this->assertSame(Address::count(), 1);

    	$this->order_details['firstName'] = $user->first_name;
    	$this->order_details['lastName'] = $user->last_name;
    	$this->order_details['email'] = $user->email;
    	$this->order_details['address']['street1'] = $address->street_1;
    	$this->order_details['address']['street2'] = $address->street_2;
    	$this->order_details['address']['city'] = $address->city;
    	$this->order_details['address']['state'] = $address->state;
    	$this->order_details['address']['zip'] = $address->zip;

    	$request = Request::create('/createOrder', 'POST', $this->order_details);
    	$response = (new MagicController)->createOrder($request);

    	$created_order = Order::all()->last();

    	$this->assertSame(Address::count(), 1);
    	$this->assertSame($created_order->address_id, $address->id);
    }

    public function test_create_order_adds_payment_method_if_not_in_db() {
    	$this->assertSame(PaymentMethod::count(), 0);

    	$request = Request::create('/createOrder', 'POST', $this->order_details);
    	$response = (new MagicController)->createOrder($request);

    	$this->assertSame(PaymentMethod::count(), 1);
    }

    public function test_create_order_gets_payment_method_from_db_if_it_exists_for_user() {
    	$user = User::factory()->create();
    	$payment_method = PaymentMethod::factory()->create();
    	$user->payment_method()->save($payment_method);

    	$this->assertSame(PaymentMethod::count(), 1);

    	$this->order_details['firstName'] = $user->first_name;
    	$this->order_details['lastName'] = $user->last_name;
    	$this->order_details['email'] = $user->email;
    	$this->order_details['payment']['ccNum'] = $payment_method->card_number;
    	$this->order_details['payment']['exp'] = $payment_method->expiration_date;

    	$request = Request::create('/createOrder', 'POST', $this->order_details);
    	$response = (new MagicController)->createOrder($request);

    	$created_order = Order::all()->last();

    	$this->assertSame(PaymentMethod::count(), 1);
    	$this->assertSame($created_order->payment_method_id, $payment_method->id);
    }

    public function test_create_order_creates_if_user_will_have_less_than_3_orders_this_month() {
    	$user = User::factory()->create();
    	$previous_order = Order::factory()->create(['quantity' => 1]);
    	$user->orders()->save($previous_order);

    	$this->assertSame(Order::count(), 1);

    	$this->order_details['firstName'] = $user->first_name;
    	$this->order_details['lastName'] = $user->last_name;
    	$this->order_details['email'] = $user->email;

    	$request = Request::create('/createOrder', 'POST', $this->order_details);
    	$response = (new MagicController)->createOrder($request);

    	$created_order = Order::all()->last();

    	$this->assertSame(Order::count(), 2);
		$this->assertSame($created_order->user_id, $user->id);
    }

    public function test_create_order_does_not_create_if_user_will_have_more_than_3_orders_this_month() {
    	$user = User::factory()->create();
    	$previous_order = Order::factory()->create(['quantity' => 3]);
    	$user->orders()->save($previous_order);

    	$this->assertSame(Order::count(), 1);

    	$this->order_details['firstName'] = $user->first_name;
    	$this->order_details['lastName'] = $user->last_name;
    	$this->order_details['email'] = $user->email;

    	$request = Request::create('/createOrder', 'POST', $this->order_details);
    	$response = (new MagicController)->createOrder($request);

    	$this->assertSame(Order::count(), 1);
    	$this->assertSame($response->status(), 422);
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

