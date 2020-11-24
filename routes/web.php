<?php

use Illuminate\Support\Facades\Route;

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

// TODO: Should any routes be moved to api.php?
Route::get('/', function () {
    return view('main');
});

Route::post('/magic', function (Request $request) {
	// Request
	// $request = {
	// 	"firstName": "string",
	// 	"lastName": "string",
	// 	"email": "string", # unique
	// 	"address": {
	// 		"street1": "string",
	// 		"street2": "string",
	// 		"city": "string",
	// 		"state": "string",
	// 		"zip": "string"
	// 	},
	// 	"phone": "string",
	// 	"quantity": number,
	// 	"total": "string",
	// 	"payment": {
	// 		"ccNum": "string",
	// 		"exp": "string" 
	// 	}
	// }

	$params = [
		'first_name' => $request->firstName,
		'last_name' => $request->lastName,
		'email' => $request->email,
		'address' => new Address(),
		'phone' => $request->phone,
		'quantity' => $request->quantity,
		'total' => $request->quantity * 49.99,
		'payment' => new PaymentMethod()
	];

	$user = User::find($email);
	$orders = $user->orders_for_month(date('M'));

	if (count($orders) < 3) {
		$new_order = new Order($params);
	}

	// Response
	// return
	// 201 CREATED
	// {
	// 	"id": uid
	// }

    return view('main');
});

Route::get('/magic/{uid})', function ($uid) {
	// Response
	// if ($success) {
	// 	return 
	// 	{
	// 		"firstName": "string", 
	// 		"lastName": "string", 
	// 		"email": "string", 
	// 		"address": {
	// 			"street1": "string", 
	// 			"street2": "string", 
	// 			"city": "string", 
	// 			"state": "string", 
	// 			"zip": "string",
	// 		},
	// 		"phone": "string", 
	// 		"payment": {
	// 			"ccNum": "string",
	// 			"exp": "string", 
	// 		},
	// 		"quantity": number, 
	// 		"total": "string",
	// 		 "orderDate": date, 
	// 		 "fulfilled": bool,
	// 	}
	// } else {
	// 	404 "resource not found"
	// }

    return view('main');
});

Route::patch('/magic', function (Request $request) {
	// Request
	// $request = {
	// 	"id": uid, 
	// 	"fulfilled": bool
	// }

	// Response
	// if ($success) {
	// 	return 200 || 204 "resource updated successfully"
	// } else {
	// 	return 404 "resource not found"
	// }

    return view('main');
});

Route::delete('/magic/{uid}', function ($uid) {
	// Response
	// if ($success) {
	// 	return 200 || 204 "resource deleted successfully"
	// } else {
	// 	return 404 "resource not found"
	// }

    return view('main');
});