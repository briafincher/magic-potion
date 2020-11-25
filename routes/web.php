<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 

// https://blog.pusher.com/react-laravel-application/
// Route::view('/{path?}', 'app');

// Index - Currently, this only allows for orders of one 
// product. How could we extend this to offer other products?
Route::get('/', 'App\Http\Controllers\MagicController@showOrderForm');

// Order potion
Route::post('/magic', 'App\Http\Controllers\MagicController@createOrder');

// Retrieve order
Route::get('/magic/{uid})', 'App\Http\Controllers\MagicController@showOrder');

// Update order
Route::patch('/magic', 'App\Http\Controllers\MagicController@updateOrder');

// Delete order
Route::delete('/magic/{uid}', 'App\Http\Controllers\MagicController@deleteOrder');
