<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Notifications\NotificationSender;

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
            ContentSeeder::class,
            UserRoleSeeder::class,
            UserAdminSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
