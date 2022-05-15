<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'test@site.com',
            'name' => 'user',
            'telegram' => 'tg_user2',
            'referrer' => 857,
            'comment' => 'Admin comment for user 858',
            'password' => Hash::make('password')
        ]);
        $user->assignRole(UserRole::USER);
    }
}
