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
    /**
    * GET ('/api/magic')
    *
    * Shows the Magic Potion order form by returning the 'app' view.
    *
    *  @return Illuminate\Http\Response
    */
    public function showOrderForm() {
        return view('app');
    }

    /**
    * POST ('/api/magic')
    *
    * Queries DB for matching User, Address and PaymentMethod, and/or 
    * creates new model instances. Returns details about the User after 
    * successfully placing the order.
    *
    * @param Illuminate\Http\Request $request
    * @return Illuminate\Http\Response
    */
    public function createOrder(Request $request) {

        // Retrieve or create User, Address and Payment Method instances

        $user = User::firstOrCreate(['email' => $request->email], [
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        $address = Address::firstOrCreate(['user_id' => $user->id], [
            'street_1' => $request->address['street1'],
            'street_2' => $request->address['street2'],
            'city' => $request->address['city'],
            'state' => $request->address['state'],
            'zip' => $request->address['zip']
        ]);

        $payment_method = PaymentMethod::firstOrCreate(['user_id' => $user->id], [
            'card_number' => $request->payment['ccNum'],
            'expiration_date' => $request->payment['exp']
        ]);

        // Place the Order

        $order_date = getdate();
        $num_monthly_orders = $user->ordersForMonth($order_date)->sum('quantity');

        if ($num_monthly_orders + $request->quantity <= 3) {
            $new_order = new Order([
                'quantity' => $request->quantity,
                'user_id' => $user->id,
                'address_id' => $address->id,
                'payment_method_id' => $payment_method->id
            ]);

            $new_order->save();

        } else {

            $message = 'Order request failed. Monthly order quantity cannot exceed three items.';
            session()->flash('error', $message);
            return response('error', 422);
        }

        session()->flash('success', 'Order placed successfully!');
        return response(['id' => $user->id], 201);
    }

    /**
    * GET ('/api/magic/{uid}')
    *
    * Queries DB for matching Order and returns its details.
    *
    * @param integer $id
    * @return Illuminate\Http\Response
    */
    public function showOrder($id) {
        $order = Order::find($id);

        if ($order) {
            $user = $order->user;
            $address = $order->address;
            $payment_method = $order->payment_method;

            $data = [
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
             ];

             return response($data);
        } else {
            return response('Resource not found', 404);
        }
    }

    /**
    * PATCH ('/api/magic')
    *
    * Queries DB for matching Order and updates its 'fulfilled' property.
    *
    * @param Illuminate\Http\Request $request
    * @return Illuminate\Http\Response
    */
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

    /**
    * DELETE ('/api/magic/{uid}')
    *
    * Queries DB for matching Order and deletes the record.
    *
    * @param integer $id
    * @return Illuminate\Http\Response
    */
    public function deleteOrder($id) {
        $order = Order::find($id);

        if ($order) {
            $order->delete();
            return response('Resource deleted successfully', 200);
        } else {
            return response('Resource not found', 404);
        }
    }
}
