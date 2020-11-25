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
Route::get('/', 'MagicPotionController@showOrderForm');

// Order potion
Route::post('/magic', 'MagicPotionController@createOrder)');

// Retrieve order
Route::get('/magic/{uid})', 'MagicPotionController@showOrder');
// Update order
Route::patch('/magic', 'MagicPotionController@updateOrder');

// Delete order
Route::delete('/magic/{uid}', 'MagicPotionController@deleteOrder');
