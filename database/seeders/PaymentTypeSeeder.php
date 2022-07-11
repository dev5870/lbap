<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            'name' => 'real_money',
            'commission' => '0.01', // 1%
        ]);

        PaymentType::create([
            'name' => 'gift',
            'commission' => '0',
        ]);

        PaymentType::create([
            'name' => 'referral_commission',
            'commission' => '0.1',
        ]);
    }
}
