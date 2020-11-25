<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Index
// Currently, this only allows for orders of one product. How could we extend this to offer other products?
// Route::get('/', 'App\Http\Controllers\MagicController@showOrderForm');

// Order potion
// Route::post('/magic', 'App\Http\Controllers\MagicController@createOrder)');

// Retrieve order
// Route::get('/magic/{uid})', 'App\Http\Controllers\MagicController@showOrder');
// Update order
// Route::patch('/magic', 'App\Http\Controllers\MagicController@updateOrder');

// Delete order
// Route::delete('/magic/{uid}', 'App\Http\Controllers\MagicController@deleteOrder');
