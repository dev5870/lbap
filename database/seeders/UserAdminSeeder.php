<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'admin@site.com',
            'name' => 'admin',
            'telegram' => 'tg_user',
            'password' => Hash::make('password')
        ]);
        $user->assignRole(UserRole::ADMIN);
    }
}
