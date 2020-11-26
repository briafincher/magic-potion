<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\PaymentMethod;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 3),
            'user_id' => User::factory(),
            'address_id' => Address::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'fulfilled' => false
        ];
    }
}
