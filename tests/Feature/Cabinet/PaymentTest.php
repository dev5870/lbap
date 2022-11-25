<?php
declare(strict_types=1);

namespace Tests\Feature\Cabinet;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Address;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use WithFaker;

    /**
     * @description View payments list page
     * @return void
     */
    public function test_check_payment_list_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Payment $payment */
        $payment = Payment::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        $response = $this->get(route('cabinet.payment.index'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Payments',
            $payment->full_amount,
            $payment->amount,
            $payment->commission_amount,
            'Top up',
            'Withdraw',
            'create',
            'top up'
        ]);
    }

    /**
     * @description View top up payment page
     * @return void
     */
    public function test_view_payment_top_up_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Address::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->get(route('cabinet.payment.create'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Payment',
            $user->address->address,
            'Return',
            'Create new payment',
            'How top up balance?',
            'Send coin on your Dogecoin address.',
            'Your address:',
            'Money will be credited to your balance automatically after replenishment of the address.'
        ]);
    }

    /**
     * @description View withdraw payment page
     * @return void
     */
    public function test_view_withdraw_payment_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.payment.withdraw'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Payment',
            'Return',
            'Create new payment',
            'Full amount',
            'Dogecoin address (the wallet to which the money will be transferred)',
            'Withdraw'
        ]);
    }

    /**
     * @description Create withdraw payment
     * @return void
     */
    public function test_create_withdraw_payment(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'balance' => '19000'
        ]);

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
     * @description Create withdraw payment (negative: user not enough money)
     * @return void
     */
    public function test_create_withdraw_payment_negative(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

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
