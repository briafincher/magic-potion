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

    /**
    * Show User associated with the Order.
    *
    * @return Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
    * Show Address associated with the Order.
    *
    * @return Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function address() {
        return $this->belongsTo('App\Models\Address');
    }

    /**
    * Show PaymentMethod associated with the Order.
    *
    * @return Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function payment_method() {
        return $this->belongsTo('App\Models\PaymentMethod');
    }

    /**
    * Calculates order total based on Magic Potion price of $49.99.
    *
    * @return float
    */
    public function total() {
        $price = 49.99;

    	return $this->quantity * $price;
    }
}
