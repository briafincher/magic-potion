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
    ];
}
