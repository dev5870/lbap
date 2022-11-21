<?php

namespace Tests\Unit\Service;

use App\Models\User;
use App\Models\UserTelegram;
use App\Services\UserService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use WithFaker;

    /**
     * @return void
     */
    public function test_is_email_exists(): void
    {
        $user = User::factory()->create();

        $this->assertTrue(UserService::isEmailExists($user->email));
    }

    /**
     * @return void
     */
    public function test_is_secret_key_exists(): void
    {
        $user = User::factory()->create();

        $this->assertTrue(UserService::isSecretKeyExists($user->secret_key));
    }

    /**
     * @return void
     */
    public function test_is_chat_id_exists(): void
    {
        $user = User::factory()->create();
        $userTelegram = UserTelegram::factory()->create(['user_id' => $user->id]);

        $this->assertTrue(UserService::isChatIdExists($userTelegram->chat_id));
    }
}
