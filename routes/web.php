<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// https://blog.pusher.com/react-laravel-application/
Route::view('/{path?}', 'app');

// TODO: Should any routes be moved to api.php?
// Route::get('/', function () {
//     return view('app');
// });

// Route::post('/magic', function (Request $request) {
// 	// Request
// 	// $request = {
// 	// 	"firstName": "string",
// 	// 	"lastName": "string",
// 	// 	"email": "string", # unique
// 	// 	"address": {
// 	// 		"street1": "string",
// 	// 		"street2": "string",
// 	// 		"city": "string",
// 	// 		"state": "string",
// 	// 		"zip": "string"
// 	// 	},
// 	// 	"phone": "string",
// 	// 	"quantity": number,
// 	// 	"total": "string",
// 	// 	"payment": {
// 	// 		"ccNum": "string",
// 	// 		"exp": "string" 
// 	// 	}
// 	// }

// 	$user = App\Models\User::where('email', $request->email)->get();

// 	// if ($user) {

// 	// } else {
// 		$user_params = [
// 			'first_name' => $request->firstName,
// 			'last_name' => $request->lastName,
// 			'email' => $request->email,
// 			'phone' => $request->phone
// 		];

// 		$order_params = [
// 			'quantity' => $request->quantity, // Make sure this is an integer
// 			'total' => $request->total
// 		];

// 		$address_params = [
// 			'street_1' => $request->address['street1'],
// 			'street_2' => $request->address['street2'],
// 			'city' => $request->address['city'],
// 			'state' => $request->address['state'],
// 			'zip' => $request->address['zip']
// 		];

// 		$payment_params = [
// 			'card_number' => $request->payment['ccNum'],
// 			'expiration_date' => $request->payment['exp']
// 		];

// 		$user = App\Models\User::create($user_params);

// 		$address = App\Models\Address::create($address_params);
// 		$payment_method = App\Models\PaymentMethod::create($payment_params);

// 		// $orders_this_month = $user->ordersForMonth(date('M')); // How to get today's date?

// 		// if (count($orders_this_month) < 3) {
// 		// 	$new_order = new Order($params);
// 		// 	$new_order->save();
// 		// }
// 	// }

// 	// Response
// 	// return
// 	// 201 CREATED
// 	// {
// 	// 	"id": uid
// 	// }

//     return view('main');
// });

// Route::get('/magic/{uid})', function ($uid) {
// 	// Response
// 	// if ($success) {
// 	// 	return 
// 	// 	{
// 	// 		"firstName": "string", 
// 	// 		"lastName": "string", 
// 	// 		"email": "string", 
// 	// 		"address": {
// 	// 			"street1": "string", 
// 	// 			"street2": "string", 
// 	// 			"city": "string", 
// 	// 			"state": "string", 
// 	// 			"zip": "string",
// 	// 		},
// 	// 		"phone": "string", 
// 	// 		"payment": {
// 	// 			"ccNum": "string",
// 	// 			"exp": "string", 
// 	// 		},
// 	// 		"quantity": number, 
// 	// 		"total": "string",
// 	// 		 "orderDate": date, 
// 	// 		 "fulfilled": bool,
// 	// 	}
// 	// } else {
// 	// 	404 "resource not found"
// 	// }

//     return view('main');
// });

// Route::patch('/magic', function (Request $request) {
// 	// Request
// 	// $request = {
// 	// 	"id": uid, 
// 	// 	"fulfilled": bool
// 	// }

// 	// Response
// 	// if ($success) {
// 	// 	return 200 || 204 "resource updated successfully"
// 	// } else {
// 	// 	return 404 "resource not found"
// 	// }

//     return view('main');
// });

// Route::delete('/magic/{uid}', function ($uid) {
// 	// Response
// 	// if ($success) {
// 	// 	return 200 || 204 "resource deleted successfully"
// 	// } else {
// 	// 	return 404 "resource not found"
// 	// }

//     return view('main');
// });