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

    public function ordersForMonth($date) {
    	$all_orders = Orders::where('user_id', $this->id);
    }
}
