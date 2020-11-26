<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// User-specific
// use Illuminate\Foundation\Auth\User as Autenticatable;
// use Illuminate\Notifications\Notifiable;

// class User extends Authenticatable
class User extends Model
{
    use HasFactory;
    	// , Notifiable;

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

    // HasMany Addresses and PaymentMethods ?

    // $date should be of type array --> how do you do type checking?
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
