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
            'address' => 'D7dgvMq8DogLneDzwGD1p9mwY2RdkrwZ2y',
            'user_id' => 857,
            'payment_system_id' => 1,
        ]);

        Address::create([
            'address' => 'DPb8EqnUapzGPWzWnMw8qU6yeLqNfcver4',
            'user_id' => 858,
            'payment_system_id' => 1,
        ]);

        Address::create([
            'address' => 'DG6NZJKrbR7Q7Wszs8fkxuSQP8peHffg7f',
            'payment_system_id' => 1,
        ]);

        Address::create([
            'address' => 'D5BbGoX2g6hboc5zkt3taXaB2Hqhi1ikSB',
            'payment_system_id' => 1,
        ]);

        Address::create([
            'address' => 'DRuQadkk6WjudpUMt9pdC6CQCEMEmQJNMo',
            'payment_system_id' => 1,
        ]);

        Address::create([
            'address' => 'DAXEsVod24VKytdWdVhwjkn7XP8LBw8Va5',
            'payment_system_id' => 1,
        ]);

        Address::create([
            'address' => 'DF1zzpqm9p2RarJF7rXjCvAhYE2Vrycogg',
            'payment_system_id' => 1,
        ]);

        Address::create([
            'address' => 'DPSg4keHtEUuUYtEL5VayeAcVwfzwmRRUp',
            'payment_system_id' => 1,
        ]);
    }
}
