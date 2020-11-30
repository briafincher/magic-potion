<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
    	'first_name',
    	'last_name',
    	'email',
    	'phone',
    ];

    public function address() {
        return $this->hasOne('App\Models\Address');
    }

    public function payment_method() {
        return $this->hasOne('App\Models\PaymentMethod');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order');
    }

    public function ordersForMonth($date) {
        if (gettype($date) === 'string') {
            $date = date_parse($date);
        }

        return $this->orders()
            ->whereYear('created_at', $date['year'])
            ->whereMonth('created_at', $date['mon'])
            ->get();
    }
}
