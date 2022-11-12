<?php

namespace Tests\Feature;

use App\Enums\RegistrationMethod;
use App\Jobs\SendTgMessageJob;
use App\Models\Address;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserTelegram;
use App\Models\UserTelegramCode;
use App\Models\UserUserAgent;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * @param int $method
     * @param bool $invitationOnly
     * @return void
     */
    private function setRegistrationMethod(int $method, bool $invitationOnly = false): void
    {
        $setting = Setting::first();
        $setting->registration_method = $method;
        $setting->invitation_only = $invitationOnly;
        $setting->save();
    }

    /**
     * @description View registration default page
     * @return void
     */
    public function test_view_registration_default_page(): void
    {
        $this->setRegistrationMethod(RegistrationMethod::SITE);

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
     * @description View registration telegram page
     * @return void
     */
    public function test_view_registration_telegram_page(): void
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
     * @description View registration page (when registration disabled)
     * @return void
     */
    public function test_view_registration_disabled(): void
    {
        $setting = Setting::first();
        $setting->update(['registration_method' => 100]);

        $response = $this->get('/registration');
        $response->assertStatus(200);
        $response->assertSeeText([
            'Registration disabled!'
        ]);
    }

    /**
     * @description Registration default user (positive)
     * @return void
     */
    public function test_registration_default_positive(): void
    {
        $this->setRegistrationMethod(RegistrationMethod::SITE);

        $email = $this->faker->email;

        $this->post(route('registration.store'), [
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::whereEmail($email)->first();
        Address::factory()->create(['user_id' => $user->id]);

        $this->assertDatabaseHas(User::class, ['id' => $user->id, 'email' => $email]);

        /** @var Address $address */
        $address = Address::whereUserId($user->id)->first();
        $this->assertTrue($address->user()->exists());
    }

    /**
     * @description Registration user default without free address (positive)
     * @return void
     */
    public function test_registration_default_without_free_address_positive(): void
    {
        $addresses = Address::whereNull('user_id')->get();

        foreach ($addresses as $address) {
            $address->user_id = 10;
            $address->save();
        }

        $email = $this->faker->email;

        $this->post(route('registration.store'), [
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::whereEmail($email)->first();
        $this->assertDatabaseHas(User::class, ['id' => $user->id, 'email' => $email]);
        $this->assertDatabaseMissing(Address::class, ['user_id' => $user->id]);
    }

    /**
     * @description Registration referral user
     * @return void
     */
    public function test_registration_referral(): void
    {
        $referrer = User::factory()->create();

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
     * @description Registration invitation only
     * @return void
     */
    public function test_registration_invitation_only(): void
    {
        $settings = Setting::first();
        $settings->invitation_only = true;
        $settings->save();

        $response = $this->post(route('registration.store'), [
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHas([
            'error-message' => 'Registration by invitation only',
        ]);
    }

    /**
     * @description Registration default user (negative #1)
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
     * @description Registration default user (negative #2)
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
     * @description Registration default user (negative #3)
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
     * @description View login page
     * @return void
     */
    public function test_view_login_page(): void
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
     * @description Login to cabinet
     * @return void
     */
    public function test_login(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.index'));
    }

    /**
     * @description Notify on telegram if login
     * @return void
     */
    public function test_login_notify(): void
    {
        Queue::fake();

        /** @var User $user */
        $user = User::factory()->create();
        $user->params()->update(['login_notify' => true]);
        UserTelegram::factory()->create(['user_id' => $user->id]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        Queue::assertPushed(SendTgMessageJob::class);

        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.index'));
    }

    /**
     * @description Login to cabinet (negative #1)
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
     * @description Login to cabinet (negative #2)
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
     * @description Login to cabinet (negative #3)
     * @return void
     */
    public function test_login_rate_limiter_negative(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        for($i = 1; $i <= 6; $i++) {
            $response = $this->post(route('login.store'), [
                'email' => $user->email,
                'password' => 'password' . $i,
            ]);
        }

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'email' => 'Exceeded allowed number of login attempts! Try later.',
        ]);
    }

    /**
     * @description Login to cabinet with mfa
     * @return void
     */
    public function test_login_with_mfa(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->params()->update([
            'mfa' => true
        ]);

        $responseMfa = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $responseMfa->assertStatus(302);
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

        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.index'));
    }

    /**
     * @description Login to cabinet with mfa (incorrect code)
     * @return void
     */
    public function test_login_with_mfa_negative(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->params()->update([
            'mfa' => true
        ]);

        $responseMfa = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $responseMfa->assertStatus(302);
        $responseMfa->assertRedirect(route('login.create') . '?mfa');
        $responseMfa->assertSessionHas([
            'error-message' => 'Please, enter 2fa code!',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
            'code' => 1111
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas([
            'error-message' => 'Please, enter 2fa code!',
        ]);
    }

    /**
     * @description User logout from cabinet
     * @return void
     */
    public function test_logout(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->get('/cabinet');

        $response = $this->post(route('user.logout'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login.create'));
    }

    /**
     * @description User trying go to admin panel
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

    /**
     * @description View login history page
     * @return void
     */
    public function test_view_login_history_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        /** @var UserUserAgent $log */
        $log = UserUserAgent::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('cabinet.user.log'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'My login history',
            $log->ip,
            $log->user_agent
        ]);

        $this->assertTrue($user->logs()->exists());
    }
}
