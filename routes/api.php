<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Index
Route::get('/', 'App\Http\Controllers\MagicController@showOrderForm');

// Order Magic Potion
Route::post('/magic', 'App\Http\Controllers\MagicController@createOrder');

// Retrieve order details
Route::get('/magic/{uid}', 'App\Http\Controllers\MagicController@showOrder');

// Update order
Route::patch('/magic', 'App\Http\Controllers\MagicController@updateOrder');

// Delete order
Route::delete('/magic/{uid}', 'App\Http\Controllers\MagicController@deleteOrder');
