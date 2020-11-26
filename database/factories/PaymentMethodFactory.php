<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'card_number' => $this->faker->creditCardNumber,
            'expiration_date' => $this->faker->creditCardExpirationDate,
            'user_id' => User::factory()
        ];
    }
}
