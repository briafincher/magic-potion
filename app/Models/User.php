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

    /**
    * Show Addresses associated with the User.
    *
    * @return Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function address() {
        return $this->hasOne('App\Models\Address');
    }

    /**
    * Show PaymentMethod associated with the User.
    *
    * @return Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function payment_method() {
        return $this->hasOne('App\Models\PaymentMethod');
    }

    /**
    * Show Orders associated with the User.
    *
    * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function orders() {
        return $this->hasMany('App\Models\Order');
    }

    /**
    * Show Orders from the given month that are associated with 
    * the User.
    *
    * @return Illuminate\Database\Eloquent\Collection
    */
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
