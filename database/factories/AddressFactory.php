<?php

namespace Database\Factories;

use App\Models\PaymentSystem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $paymentSystem = PaymentSystem::all();

        return [
            'address' => $this->faker->text(20),
            'payment_system_id' => $paymentSystem->first(),
        ];
    }
}
