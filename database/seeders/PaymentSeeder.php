<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'user_id' => 857,
            'address_id' => 1,
            'status' => PaymentStatus::CREATE,
            'type' => PaymentType::TOP_UP,
            'full_amount' => '1874200300.87452982',
            'amount' => '1754875642.87265392',
            'commission_amount' => '18745249.74635285',
        ]);

        Payment::create([
            'user_id' => 857,
            'address_id' => 1,
            'status' => PaymentStatus::CREATE,
            'type' => PaymentType::TOP_UP,
            'full_amount' => '245.08462946',
            'amount' => '180.76381935',
            'commission_amount' => '20.38726492',
        ]);

        Payment::create([
            'user_id' => 858,
            'address_id' => 2,
            'status' => PaymentStatus::CREATE,
            'type' => PaymentType::MINUS,
            'full_amount' => '90.76491257',
            'amount' => '81.76398728',
            'commission_amount' => '9.75648362',
        ]);
    }
}
