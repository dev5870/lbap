<?php
declare(strict_types=1);

namespace Tests\Unit\Job;

use App\Jobs\SendTgMessageJob;
use App\Models\User;
use App\Models\UserTelegram;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendTgMessageJobTest extends TestCase
{
    use WithFaker;

    public function test_send_message(): void
    {
        $user = User::factory()->create();
        UserTelegram::factory()->create(['user_id' => $user->id]);
        $message = $this->faker->text;

        $job = new SendTgMessageJob($user, $message);
        $this->assertTrue($job->handle());
    }

    public function test_send_message_negative(): void
    {
        $user = User::factory()->create();
        $message = $this->faker->text;

        $job = new SendTgMessageJob($user, $message);
        $this->assertFalse($job->handle());
    }
}
