<?php

namespace Tests\Feature;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Content;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\User;
use App\Models\UserParam;
use App\Models\UserTelegram;
use App\Models\UserUserAgent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CabinetTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Update profile
     */
    public function test_update_profile()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'username' => $this->faker->userName,
            'about' => 'about test',
            'skill' => 'skill',
            'city' => 'London',
            'telegram' => '@tg_name_111',
            'description' => 'description test',
        ];

        $response = $this->put(route('cabinet.profile.update', $user->params), [
            'username' => $params['username'],
            'about' => $params['about'],
            'skill' => $params['skill'],
            'city' => $params['city'],
            'telegram' => $params['telegram'],
            'description' => $params['description'],
        ]);

        $this->assertDatabaseHas(UserParam::class, ['user_id' => $user->id]);
        $this->assertDatabaseHas(UserParam::class, ['username' => $params['username']]);
        $this->assertDatabaseHas(UserParam::class, ['about' => $params['about']]);
        $this->assertDatabaseHas(UserParam::class, ['skill' => $params['skill']]);
        $this->assertDatabaseHas(UserParam::class, ['city' => $params['city']]);
        $this->assertDatabaseHas(UserParam::class, ['telegram' => $params['telegram']]);
        $this->assertDatabaseHas(UserParam::class, ['description' => $params['description']]);

        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.profile.edit', $user->params));
    }

    /**
     * Edit profile page
     */
    public function test_check_edit_profile_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.profile.edit', $user->params));

        $response->assertStatus(200);
        $response->assertSeeText('Profile details');
        $response->assertSeeText('tell us about yourself, your services and products');
        $response->assertSeeText('Update');
        $response->assertSeeText('Balance');
    }

    /**
     * See profile page (before create params with factory)
     */
    public function test_check_show_profile_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'username' => $this->faker->userName,
            'about' => 'about test',
            'skill' => 'skill',
            'city' => 'London',
            'telegram' => '@tg_name_111',
            'description' => 'description test',
        ];

        $user->params()->update([
            'username' => $params['username'],
            'about' => $params['about'],
            'skill' => $params['skill'],
            'city' => $params['city'],
            'telegram' => $params['telegram'],
            'description' => $params['description'],
        ]);

        $response = $this->get(route('cabinet.profile.show', $user->params));
        $response->assertStatus(200);
        $response->assertSeeText('Profile details');
        $response->assertSeeText('tell about yourself');
        $response->assertSeeText('Balance');
        $response->assertSeeText($params['username']);
        $response->assertSeeText($params['about']);
        $response->assertSeeText($params['skill']);
        $response->assertSeeText($params['city']);
        $response->assertSeeText($params['telegram']);
        $response->assertSeeText($params['description']);
    }

    /**
     * Security (without tg - button disabled)
     */
    public function test_security_check_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.user.security'));

        $response->assertSeeText('To configure, you need to subscribe to our telegram bot. Start the bot and send the secret code to the bot');
        $response->assertSeeText('Your secret key:');
        $response->assertSeeText($user->secret_key);
        $response->assertSeeText('Update');
    }

    /**
     * Security update (negative without tg)
     */
    public function test_security_update_negative()
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
     * Security update (with tg - create from factory then update security)
     */
    public function test_security_update_positive()
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

    /**
     * Check referral program page
     */
    public function test_check_referral_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.user.referral'));

        $response->assertStatus(200);
        $response->assertSeeText('Your referrals');
        $response->assertSeeText('Your partner link');
        $response->assertSeeText('Total referrals');
        $response->assertSeeText($user->params->user_uuid);
    }

    /**
     * Check content list page
     */
    public function test_check_content_list_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        /** @var Content $content */
        $content = Content::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.content.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Contents');
        $response->assertSeeText($content->title);
        $response->assertSeeText($content->preview);
        $response->assertSeeText('Read');
    }

    /**
     * Check content show page
     */
    public function test_check_content_show_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        /** @var Content $content */
        $content = Content::factory()->create();
        $content->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.content.show', $content));

        $response->assertStatus(200);
        $response->assertSeeText('Return');
        $response->assertSeeText($content->title);
        $response->assertSeeText($content->text);
        $response->assertSeeText($content->delayed_time_publication);
    }

    /**
     * Check payments list page
     */
    public function test_check_payment_list_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        /** @var Payment $payment */
        $payment = Payment::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        $response = $this->get(route('cabinet.payment.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Payments');
        $response->assertSeeText($payment->full_amount);
        $response->assertSeeText($payment->amount);
        $response->assertSeeText($payment->commission_amount);
        $response->assertSeeText('Top up');
        $response->assertSeeText('Withdraw');
        $response->assertSeeText('create');
        $response->assertSeeText('top up');
    }

    /**
     * Check top up payment page
     */
    public function test_check_payment_top_up_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.payment.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Payment');
        $response->assertSeeText($user->address->address);
        $response->assertSeeText('Return');
        $response->assertSeeText('Create new payment');
        $response->assertSeeText('How top up balance?');
        $response->assertSeeText('Send coin on your Dogecoin address.');
        $response->assertSeeText('Your address:');
        $response->assertSeeText('Money will be credited to your balance automatically after replenishment of the address.');
    }

    /**
     * Check withdraw payment page (positive)
     */
    public function test_check_payment_withdraw_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.payment.withdraw'));

        $response->assertStatus(200);
        $response->assertSeeText('Payment');
        $response->assertSeeText('Return');
        $response->assertSeeText('Create new payment');
        $response->assertSeeText('Full amount');
        $response->assertSeeText('Dogecoin address (the wallet to which the money will be transferred)');
        $response->assertSeeText('Withdraw');
    }

    /**
     * Create withdraw payment (positive)
     */
    public function test_create_withdraw_payment_positive()
    {
        /** @var User $user */
        $user = User::factory()->create([
            'balance' => '19000'
        ]);
        $user->refresh();

        $paymentType = PaymentType::whereName('real_money')->first();

        $this->actingAs($user);

        $response = $this->post(route('cabinet.payment.store'), [
            'full_amount' => '9000',
            'address' => 'DPSg4keHtEUuUYtEL5VayeAcVwfzwmRRUp',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.payment.index'));
        $this->assertDatabaseHas(Payment::class, [
            'user_id' => $user->id,
            'status' => PaymentStatus::CREATE,
            'payment_type_id' => $paymentType->id,
            'method' => PaymentMethod::WITHDRAW,
            'full_amount' => '-9000.00000000',
            'amount' => '-8910.00000000',
            'commission_amount' => '-90.00000000',
            'description' => 'User withdraw balance DPSg4keHtEUuUYtEL5VayeAcVwfzwmRRUp',
        ]);
    }

    /**
     * Create withdraw payment (negative: user not enough money)
     */
    public function test_create_withdraw_payment_negative()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->post(route('cabinet.payment.store'), [
            'full_amount' => '9000',
            'address' => 'DPSg4keHtEUuUYtEL5VayeAcVwfzwmRRUp',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.payment.withdraw'));
        $response->assertSessionHas([
            'error-message' => 'Can\'t create withdraw payment',
        ]);
    }

    /**
     * Check login history page (positive)
     */
    public function test_check_login_history_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        /** @var UserUserAgent $log */
        $log = UserUserAgent::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('cabinet.user.log'));

        $response->assertStatus(200);
        $response->assertSeeText('My login history');
        $response->assertSeeText($log->ip);
        $response->assertSeeText($log->user_agent);
    }
}
