<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notification::create([
            'text' => 'Example notification Example notification Example notification Example notification Example notification Example notification',
            'type' => \App\Enums\NotificationType::PRIMARY,
            'status' => \App\Enums\NotificationStatus::ACTIVE,
        ]);
    }
}
