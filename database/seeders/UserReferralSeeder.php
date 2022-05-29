<?php

namespace Database\Seeders;

use App\Models\UserReferral;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserReferral::create([
            'user_id' => '857',
            'referral_id' => '858',
        ]);
    }
}
