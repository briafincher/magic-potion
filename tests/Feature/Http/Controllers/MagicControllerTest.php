<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\MagicController;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\PaymentMethod;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class MagicControllerTest extends TestCase
{
	use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->order_details = [
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
    }

   	/**
    * Tests that GET '/api' shows the order form by returning the 'app'
    * view.
    *
    * @return void
    */
    /** @test */
    public function test_show_order_form_method_returns_app_view() {
        $response = $this->get('/api');

    	$view_name = $response->original->name();

    	$this->assertSame($view_name, 'app');
    }	

   /**
   * Tests that POST '/api/magic' returns details about the User after
   * successfully placing the order.
   *
   * @return void
   */
   /** @test */
    public function test_create_order_method_returns_user_details() {
        $response = $this->post('/api/magic/', $this->order_details);

    	$this->assertSame($response->status(), 201);
    	$this->assertSame($response->getContent(), json_encode([
    		'id' => User::all()->last()->id
    	]));
    }

   /**
   * Tests that POST '/api/magic' returns a 500 status code when there is
   * an error creating the order.
   *
   * @return void
   */
   /** @test */
    public function test_create_order_method_returns_500_if_there_is_an_error_creating_the_order() {
    	// TODO: Fill me in!!
    }

    /**
    * Tests that POST '/api/magic' creates a User if one does not already
    * exist in the database.
    *
    * @return void
    */
    /** @test */
    public function test_create_order_method_adds_user_if_not_in_db() {
    	$this->assertSame(User::count(), 0);

        $response = $this->post('/api/magic/', $this->order_details);

    	$this->assertSame(User::count(), 1);
    }

    /**
    * Tests that POST '/api/magic' retrieves a User from the database if
    * it already exists.
    *
    * @return void
    */
    /** @test */
    public function test_create_order_method_gets_user_from_db_if_exists() {
    	$user = User::factory()->create();

    	$this->assertSame(User::count(), 1);

    	$this->order_details['firstName'] = $user->first_name;
    	$this->order_details['lastName'] = $user->last_name;
    	$this->order_details['email'] = $user->email;
    	$this->order_details['phone'] = $user->phone;

        $response = $this->post('/api/magic/', $this->order_details);

    	$created_order = Order::all()->last();

    	$this->assertSame(User::count(), 1);
    	$this->assertSame($created_order->user_id, $user->id);
   	}

    /**
    * Tests that POST '/api/magic' creates a new Address if one does not
    * already exit for the user.
    *
    * @return void
    */
    /** @test */
    public function test_create_order_method_adds_address_if_not_in_db() {
    	$this->assertSame(Address::count(), 0);

        $response = $this->post('/api/magic/', $this->order_details);

    	$this->assertSame(Address::count(), 1);
    }

    /**
    * Tests that POST '/api/magic' retrieves a user's Address from the 
    * database if it already exists and does not create a new one.
    *
    * @return void
    */
    /** @test */
    public function test_create_order_method_gets_address_from_db_if_it_exists_for_user() {
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

        $response = $this->post('/api/magic/', $this->order_details);

    	$created_order = Order::all()->last();

    	$this->assertSame(Address::count(), 1);
    	$this->assertSame($created_order->address_id, $address->id);
    }

    /**
    * Tests that POST '/api/magic' creates a new PaymentMethod if one does 
    * not already exist for the user.
    *
    * @return void
    */
    /** @test */
    public function test_create_order_method_adds_payment_method_if_not_in_db() {
    	$this->assertSame(PaymentMethod::count(), 0);

        $response = $this->post('/api/magic/', $this->order_details);

    	$this->assertSame(PaymentMethod::count(), 1);
    }

    /**
    * Tests that POST '/api/magic' retrieves a user's PaymentMethod from the 
    * database if it already exists and does not create a new one.
    *
    * @return void
    */
    /** @test */
    public function test_create_order_method_gets_payment_method_from_db_if_it_exists_for_user() {
    	$user = User::factory()->create();
    	$payment_method = PaymentMethod::factory()->create();
    	$user->payment_method()->save($payment_method);

    	$this->assertSame(PaymentMethod::count(), 1);

    	$this->order_details['firstName'] = $user->first_name;
    	$this->order_details['lastName'] = $user->last_name;
    	$this->order_details['email'] = $user->email;
    	$this->order_details['payment']['ccNum'] = $payment_method->card_number;
    	$this->order_details['payment']['exp'] = $payment_method->expiration_date;

        $response = $this->post('/api/magic/', $this->order_details);

    	$created_order = Order::all()->last();

    	$this->assertSame(PaymentMethod::count(), 1);
    	$this->assertSame($created_order->payment_method_id, $payment_method->id);
    }

    /**
    * Tests that POST '/api/magic' sucessfully creates an order if the sum 
    * of the requested order quantity and the quantity of items ordered by 
    * the user in that month does not exceed the limit of 3 items.
    *
    * @return void
    */
    /** @test */
    public function test_create_order_method_creates_order_if_quantity_within_limit() {
    	$user = User::factory()->create();
    	$previous_order = Order::factory()->create(['quantity' => 1]);
    	$user->orders()->save($previous_order);

    	$this->assertSame(Order::count(), 1);

    	$this->order_details['firstName'] = $user->first_name;
    	$this->order_details['lastName'] = $user->last_name;
    	$this->order_details['email'] = $user->email;

        $response = $this->post('/api/magic/', $this->order_details);

    	$created_order = Order::all()->last();

    	$this->assertSame(Order::count(), 2);
		$this->assertSame($created_order->user_id, $user->id);
    }

    /**
    * Tests that POST '/api/magic' does not create an order if the sum of the 
    * requested order quantity and the quantity of items ordered by the user 
    * in that month exceeds the limit of 3 items.
    *
    * @return void
    */
    /** @test */
    public function test_create_order_method_does_not_create_order_if_quantity_exceeds_limit() {
    	$user = User::factory()->create();
    	$previous_order = Order::factory()->create(['quantity' => 3]);
    	$user->orders()->save($previous_order);

    	$this->assertSame(Order::count(), 1);

    	$this->order_details['firstName'] = $user->first_name;
    	$this->order_details['lastName'] = $user->last_name;
    	$this->order_details['email'] = $user->email;

        $response = $this->post("/api/magic", $this->order_details);

    	$this->assertSame(Order::count(), 1);
    	$this->assertSame($response->status(), 422);
    }

    /**
    * Tests that GET '/api/magic/{uid}' returns details about the requested 
    * order when it exists in the database.
    *
    * @return void
    */
    /** @test */
    public function test_show_order_method_returns_order_details_when_it_exists() {
        $order = Order::factory()->create();
        $user = $order->user;
        $address = $order->address;
        $payment_method = $order->payment_method;

        $response = $this->get("/api/magic/{$order->id}");

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

    /**
    * Tests that GET '/api/magic/{uid}' returns a 404 status code when the 
    * requested order does not exist in the database.
    *
    * @return void
    */
    /** @test */
    public function test_show_order_method_returns_404_when_order_does_not_exist() {
    	$order = Order::factory()->create();
    	$order->delete();

        $response = $this->get("/api/magic/{$order->id}");

        $this->assertSame($response->status(), 404);
    }

    /**
    * Tests that PATCH '/api/magic' updates the requested order's fulfilled
    * column when the order exists in the database.
    *
    * @return void
    */
    /** @test */
    public function test_update_order_method_updates_fulfilled_column_when_order_exists() {
    	$order = Order::factory()->create();
    	$this->assertSame($order->fulfilled, false);

        $response = $this->patch("/api/magic", [
            'id' => $order->id,
            'fulfilled' => true
        ]);

    	$this->assertSame($response->status(), 200);
    	$this->assertSame($order->refresh()->fulfilled, true);
    }

    /**
    * Tests that PATCH '/api/magic' returns a 404 status code when the 
    * requested order does not exist in the database.
    *
    * @return void
    */
    /** @test */
    public function test_update_order_method_returns_404_when_order_does_not_exist() {
    	$order = Order::factory()->create();
    	$order->delete();

        $response = $this->patch("/api/magic", [
            'id' => $order->id,
            'fulfilled' => true
        ]);

    	$this->assertSame($response->status(), 404);
    }

    /**
    * Tests that DELETE '/api/magic/{uid}' successfully deletes a requested 
    * order if it exists in the database.
    *
    * @return void
    */
    /** @test */
    public function test_delete_order_method_destroys_order_when_it_exists() {
    	$order = Order::factory()->create();

        $response = $this->delete("/api/magic/{$order->id}");

    	$this->assertSame($response->status(), 200);
    	$this->assertDeleted($order);
    }

    /**
    * Tests that DELETE '/api/magic/{uid}' returns a 404 status code when the 
    * requested order does not exist in the database.
    *
    * @return void
    */
    /** @test */
    public function test_delete_order_method_returns_404_when_order_does_not_exist() {
    	$order = Order::factory()->create();
    	$order->delete();

        $response = $this->delete("/api/magic/{$order->id}");

    	$this->assertSame($response->status(), 404);
    }
}

