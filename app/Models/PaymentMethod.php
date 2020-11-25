<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
    	'card_number',
    	'expiration_date'
    ];

    public function user() {
    	return $this->hasOne('App\Models\User');
    }
}
