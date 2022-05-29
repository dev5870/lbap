<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingSeeder::class,
            PaymentSystemSeeder::class,
            ContentSeeder::class,
            UserRoleSeeder::class,
            UserAdminSeeder::class,
            UserSeeder::class,
            UserReferralSeeder::class,
            AddressSeeder::class,
            PaymentSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
