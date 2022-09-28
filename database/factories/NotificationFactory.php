<?php

namespace Database\Factories;

use App\Enums\NotificationStatus;
use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'text' => 'Test notification text',
            'status' => NotificationStatus::ACTIVE,
            'type' => NotificationType::INFO,
        ];
    }
}
