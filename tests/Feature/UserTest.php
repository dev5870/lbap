<?php

namespace Tests\Feature;

use App\Enums\RegistrationMethod;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserTelegramCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check registration default page
     *
     * @return void
     */
    public function test_check_registration_default_page(): void
    {
        $response = $this->get('/registration');
        $response->assertStatus(200);
        $response->assertSeeText([
            'Registration',
            'Email address',
            'Password',
            'Repeat password',
            'Submit',
        ]);
    }

    /**
     * Check registration telegram page
     *
     * @return void
     */
    public function test_check_registration_telegram_page(): void
    {
        $setting = Setting::first();
        $setting->registration_method = RegistrationMethod::TELEGRAM;
        $setting->save();

        $response = $this->get('/registration');
        $response->assertStatus(200);
        $response->assertSeeText([
            'For registration use telegram!',
            'Telegram bot',
        ]);
    }

    /**
     * Registration default user (positive)
     *
     * @return void
     */
    public function test_registration_default_positive(): void
    {
        $email = $this->faker->email;

        $this->post(route('registration.store'), [
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas(User::class, ['email' => $email]);
    }

    /**
     * Registration referral user (positive)
     *
     * @return void
     */
    public function test_registration_referral_positive(): void
    {
        $referrer = User::factory()->create();
        $referrer->refresh();

        $referralEmail = $this->faker->email;

        $this->post(route('registration.store'), [
            'email' => $referralEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'invite' => $referrer->params->user_uuid,
        ]);

        $this->assertDatabaseHas(User::class, [
            'email' => $referralEmail,
            'referrer' => $referrer->id,
        ]);
    }

    /**
     * Registration default user (negative #1)
     *
     * @return void
     */
    public function test_registration_default_negative1(): void
    {
        $response = $this->post(route('registration.store'), [
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email field is required.',
        ]);
    }

    /**
     * Registration default user (negative #2)
     *
     * @return void
     */
    public function test_registration_default_negative2(): void
    {
        $response = $this->post(route('registration.store'), [
            'email' => $this->faker->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password confirmation does not match.',
        ]);
    }

    /**
     * Registration default user (negative #3)
     *
     * @return void
     */
    public function test_registration_default_negative3(): void
    {
        $response = $this->post(route('registration.store'), [
            'email' => $this->faker->email,
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field is required.',
        ]);
    }

    /**
     * Check login page
     *
     * @return void
     */
    public function test_check_login_page(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSeeText([
            'Authorization',
            'Email address',
            'Password',
            'Submit',
        ]);
    }

    /**
     * Login to cabinet (positive)
     *
     * @return void
     */
    public function test_login_positive(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->status(302);
        $response->assertRedirect(route('cabinet.index'));
    }

    /**
     * Login to cabinet (negative #1)
     *
     * @return void
     */
    public function test_login_negative1(): void
    {
        $response = $this->post(route('login.store'), [
            'email' => $this->faker->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Auth error!',
        ]);
    }

    /**
     * Login to cabinet (negative #2)
     *
     * @return void
     */
    public function test_login_negative2(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'incorrect',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Auth error!',
        ]);
    }

    /**
     * Login to cabinet
     *
     * @return void
     */
    public function test_login_with_mfa(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $user->params()->update([
            'mfa' => true
        ]);

        $responseMfa = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $responseMfa->status(302);
        $responseMfa->assertRedirect(route('login.create') . '?mfa');
        $responseMfa->assertSessionHas([
            'error-message' => 'Please, enter 2fa code!',
        ]);

        $telegramCode = UserTelegramCode::whereUserId($user->id)->first();

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
            'code' => $telegramCode->code
        ]);

        $response->status(302);
        $response->assertRedirect(route('cabinet.index'));
    }

    /**
     * User logout from cabinet
     *
     * @return void
     */
    public function test_logout(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->get('/cabinet');

        $response = $this->post(route('user.logout'));
        $response->status(302);
        $response->assertRedirect(route('login.create'));
    }

    /**
     * User trying go to admin panel
     *
     * @return void
     */
    public function test_user_go_to_admin_panel(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->get(route('admin.dashboard'));
        $response->assertForbidden();
        $response->assertSeeText('User does not have the right roles.');
    }
}
