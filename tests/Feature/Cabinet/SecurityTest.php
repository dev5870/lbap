<?php

namespace Tests\Feature\Cabinet;

use App\Models\User;
use App\Models\UserTelegram;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use WithFaker;

    /**
     * @description View security page (without tg - button disabled)
     * @return void
     */
    public function test_view_security_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.user.security'));

        $response->assertSeeText([
            'To configure, you need to subscribe to our telegram bot. Start the bot and send the secret code to the bot',
            'Your secret key:',
            $user->secret_key,
            'Update'
        ]);
    }

    /**
     * @description Security update (negative without tg)
     * @return void
     */
    public function test_security_update_negative(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->post(route('cabinet.user.security.update'), [
            'mfa' => 'on',
            'login_notify' => 'on',
        ]);

        $response->assertSessionHas([
            'error-message' => 'Can\'t update',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.user.security'));
    }

    /**
     * @description Security update (with tg - create from factory then update security)
     * @return void
     */
    public function test_security_update_positive(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        UserTelegram::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->post(route('cabinet.user.security.update'), [
            'mfa' => 'on',
            'login_notify' => 'on',
        ]);

        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.user.security'));
    }
}
