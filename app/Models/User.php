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

    // $date should be of type array --> how do you do type checking?
    public function ordersForMonth($date = getdate()) {
        if (gettype($date) === 'string') {
            $date = date_parse($date);
        }

        // Is this the idiomatic way to write a filtering function?
        $monthly_orders = $this->orders->filter(function ($value, $key) {
            $month = $date['mon'];
            $year = $date['year'];
            return $value->created_at->year === $date['year'] && $value->created_at->month === $date['mon'];
        });

        return $monthly_orders;
    }
}
