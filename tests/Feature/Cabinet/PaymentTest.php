<?php

namespace Tests\Feature\Cabinet;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

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
}
