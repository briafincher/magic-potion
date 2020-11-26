<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    	'quantity',
    	'user_id',
    	'address_id',
    	'payment_method_id',
    	'fulfilled'
    ];

    protected $casts = [
        'fulfilled' => 'boolean'
    ];

    // Do we have to do it this way? Lol
    private const MAGIC_POTION_PRICE = 49.99;

    // public function price() {
    // 	return $this::MAGIC_POTION_PRICE;
    // }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function address() {
        return $this->belongsTo('App\Models\Address');
    }

    public function payment_method() {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

    public function total() {
    	return $this->quantity * $this::MAGIC_POTION_PRICE;
    }
}

// THOUGHT: Can we do something fancy with having an Order have many products?