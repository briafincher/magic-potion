<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
    	'card_number',
    	'expiration_date',
        'user_id'
    ];

    public function user() {
    	return $this->belongsTo('App\Models\User');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order');
    }
}
