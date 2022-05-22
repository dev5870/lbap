<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::create([
            'address' => '11iuy87t6745yff54e75ui68',
            'user_id' => 857,
            'payment_system_id' => 1,
        ]);

        Address::create([
            'address' => '22iuy87t6745yff54e75ui68',
            'user_id' => 858,
            'payment_system_id' => 1,
        ]);

        Address::create([
            'address' => '33iuy87t6745yff54e75ui68',
            'payment_system_id' => 1,
        ]);
    }
}
