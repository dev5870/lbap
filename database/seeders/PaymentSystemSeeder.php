<?php

namespace Database\Seeders;

use App\Models\PaymentSystem;
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
            'name' => 'Dogecoin',
            'iso_code' => 'DOGE',
        ]);
    }
}
