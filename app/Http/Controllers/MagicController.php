<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;

use Illuminate\Http\Request;

class MagicController extends Controller
{
    public function showOrderForm() {
    	return view('app');
    }

    public function createOrder(Request $request) {
        // $product_id

        // Do this in a transaction??

        // $email = $request->email;
        $user_params = [
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone
        ];

        // For simplicity's sake, Users are 1:1 with Addresses, or else it'd be too much of a pain to figure out if we should create the Address or not, or just pull one up in the database??? This is late night rambling I need to sleep I'm not making sense
        $address_params = [
            'street_1' => $request->address['street1'],
            'street_2' => $request->address['street2'],
            'city' => $request->address['city'],
            'state' => $request->address['state'],
            'zip' => $request->address['zip']
        ];

        // This is likely a security issue. Should each card have just one User?
        $payment_params = [
            'card_number' => $request->payment['ccNum'],
            'expiration_date' => $request->payment['exp']
        ];

        $order_params = [
            'quantity' => $request->quantity, // Make sure this is an integer
            'user_id' => 1,
            'address_id' => 1,
            'payment_method_id' => 1
            // Do we need to add more stuff to point to the products? No, because we're given a request structure, so that implies that there aren't any more complex relationships between the order and the product :)
        ];

        $user = User::firstOrCreate(['email' => $request->email], $user_params);
        $address = Address::firstOrNew(['user_id' => $user->id], $address_params);
        $payment_method = PaymentMethod::firstOrNew(['user_id' => $user->id], $payment_params);

        $orders_this_month = $user->ordersForMonth(getdate());

        if (count($orders_this_month) < 3) {
         $new_order = new Order($order_params);
         $new_order->save();
        }

        $response = [ 'id': $user->id ]->toJson();

        return response($response, 201);
        // return $request->toJson();
        // return view('app');
    }

    public function showOrder($id) {
        $order = Order::find($id);

        if ($order) {
            $user = User::find($order->user_id);
            $address = Address::find($user->address_id);
            $payment_method = PaymentMethod::find($user->payment_method_id);

            $data = [
                "firstName" => $user->first_name, 
                "lastName" => $user->last_name, 
                "email" => $user->email, 
                "address" => [
                    "street1" => $address->street_1, 
                    "street2" => $address->street_2, 
                    "city" => $address->city, 
                    "state" => $address->state, 
                    "zip" => $address->zip,
                ],
                "phone" => $user->phone_number, 
                "payment" => [
                    "ccNum" => $payment_method->card_number,
                    "exp" => $payment_method->card_number, 
                ],
                "quantity" => $order->quantity, 
                "total" => $order->total(),
                 "orderDate" => $order->created_at, 
                 "fulfilled" => $order->fulfilled
             ];

             return response($data)->toJson();
         } else {
            return response('Resource not found', 404);
         }

        return view('app');
    }

    public function updateOrder(Request $request) {
        $order = Order::find($request->id);

        if ($order) {
            $order->fulfilled = $request->fulfilled;
            $order->save();

            return response('Resource updated successfully', 200);
        } else {
            return response('Resource not found', 404);
        }
    }

    public function deleteOrder($id) {
        $order = Order::find($id);

        if ($order) {
            $order->destroy();

            return response('Resource deleted successfully', 200);
        } else {
            return response('Resource not found', 404);
        }
    }
}
