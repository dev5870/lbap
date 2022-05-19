<?php

namespace Database\Seeders;

use App\Models\PaymentSystem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentSystem::create([
            'name' => 'Bitcoin',
            'iso_code' => 'BTC',
        ]);
    }
}
