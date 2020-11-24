<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// User-specific
use Illuminate\Foundation\Auth\User as Autenticatable;
// use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    	// , Notifiable;
}
