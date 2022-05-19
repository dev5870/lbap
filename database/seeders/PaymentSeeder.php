<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Models\Payment;
use Carbon\Carbon;
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
            'status' => PaymentStatus::CREATE,
            'type' => PaymentType::TOP_UP,
            'full_amount' => 150,
            'amount' => 135,
            'commission_amount' => 15,
        ]);

        Payment::create([
            'user_id' => 857,
            'status' => PaymentStatus::PAID,
            'type' => PaymentType::TOP_UP,
            'full_amount' => 200,
            'amount' => 180,
            'commission_amount' => 20,
            'paid_at' => Carbon::now(),
        ]);

        Payment::create([
            'user_id' => 858,
            'status' => PaymentStatus::CREATE,
            'type' => PaymentType::MINUS,
            'full_amount' => 90,
            'amount' => 81,
            'commission_amount' => 9,
        ]);
    }
}
