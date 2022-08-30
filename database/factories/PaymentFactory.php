<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\PaymentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status' => PaymentStatus::CREATE,
            'payment_type_id' => PaymentType::whereName('real_money')->first()->id,
            'method' => PaymentMethod::TOP_UP,
            'description' => 'User top up balance',
            'full_amount' => '900',
            'amount' => '850',
            'commission_amount' => '50',
        ];
    }
}
