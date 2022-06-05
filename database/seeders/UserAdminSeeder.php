<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
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
            'comment' => 'Admin comment for user 857',
            'password' => Hash::make('password')
        ]);
        $user->assignRole(UserRole::ADMIN);
    }
}
