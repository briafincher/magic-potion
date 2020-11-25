<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\User;

use Illuminate\Http\Request;

class MagicPotionController extends Controller
{
    public function showOrderForm() {
    	return views('app');
    }

    public function createOrder(Request $request) {

    }

    public function showOrder($id) {

    }

    public function updateOrder(Request $request) {

    }

    public function deleteOrder($id) {

    }
}
