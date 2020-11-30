<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
    	'street_1',
    	'street_2',
    	'city',
    	'state',
    	'zip',
        'user_id'
    ];

    /**
    * Show User associated with the Address.
    *
    * @return Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function user() {
    	return $this->belongsTo('App\Models\User');
    }

    /**
    * Show Orders associated with the Address.
    *
    * @return Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function orders() {
        return $this->hasMany('App\Models\Order');
    }
}
