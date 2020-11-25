<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    	'quantity',
    	'fulfilled',
    ];

    public function total() {
    	$price = 49.99;
    	
    	return $this->quantity * $price;
    }
}

// THOUGHT: Can we do something fancy with having an Order have many products?