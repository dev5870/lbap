<?php
declare(strict_types=1);

namespace Tests\Unit\Service;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Transaction;
use App\Models\User;
use App\Services\ReferralPaymentService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReferralPaymentServiceTest extends TestCase
{
    use WithFaker;

    private function createTransaction(string $commission = '50', User $referrer = null, int $method = PaymentMethod::TOP_UP): Transaction
    {
        $user = User::factory()->create(['referrer' => $referrer?->id]);
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'status' => PaymentStatus::PAID,
            'commission_amount' => $commission
        ]);
        /** @var Transaction $transaction */
        $transaction = Transaction::factory()->create([
            'payment_id' => $payment->id,
            'commission_amount' => $commission
        ]);

        return $transaction;
    }

    public function test_referral_payment_without_commission(): void
    {
        $transaction = $this->createTransaction('0');
        $paymentsBefore = Payment::count();
        $referralPaymentService = app(ReferralPaymentService::class);
        $referralPaymentService->handle($transaction);
        $paymentsAfter = Payment::count();

        $this->assertEquals($paymentsBefore, $paymentsAfter);
    }

    public function test_referral_payment_not_referral(): void
    {
        $transactionCount = Transaction::count();
        $paymentCount = Payment::count();
        $this->createTransaction();

        $this->assertDatabaseCount(Transaction::class, $transactionCount + 1);
        $this->assertDatabaseCount(Payment::class, $paymentCount + 1);
    }

    public function test_referral_payment_already_paid(): void
    {
        $referrer = User::factory()->create();
        $transaction = $this->createTransaction('50', $referrer);
        $type = PaymentType::whereName('referral_commission')->first();
        $parentTransaction = Payment::factory()->create([
            'user_id' => $transaction->payment->user->id,
            'parent_id' => $transaction->id,
            'payment_type_id' => $type->id
        ]);
        $paymentsBefore = Payment::count();
        $referralPaymentService = app(ReferralPaymentService::class);
        $referralPaymentService->handle($transaction);
        $paymentsAfter = Payment::count();

        $this->assertEquals($paymentsBefore, $paymentsAfter);
    }

    public function test_referral_payment_less_than(): void
    {
        $referrer = User::factory()->create();
        $transaction = $this->createTransaction('0.0000001', $referrer);
        $paymentsBefore = Payment::count();
        $referralPaymentService = app(ReferralPaymentService::class);
        $referralPaymentService->handle($transaction);
        $paymentsAfter = Payment::count();

        $this->assertEquals($paymentsBefore, $paymentsAfter);
    }

    public function test_referral_payment_top_up(): void
    {
        $referrer = User::factory()->create();
        $type = PaymentType::whereName('referral_commission')->first();
        $transactionCount = Transaction::count();
        $paymentCount = Payment::count();
        $transaction = $this->createTransaction('50', $referrer);

        $this->assertDatabaseCount(Transaction::class, $transactionCount + 1);
        $this->assertDatabaseCount(Payment::class, $paymentCount + 2);
        $this->assertDatabaseHas(Payment::class, [
            'parent_id' => $transaction->id,
            'commission_amount' => '0',
            'full_amount' => '5',
            'amount' => '5',
            'payment_type_id' => $type->id,
            'status' => PaymentStatus::CREATE,
            'method' => PaymentMethod::TOP_UP
        ]);
    }

    public function test_referral_payment_withdraw(): void
    {
        $referrer = User::factory()->create();
        $type = PaymentType::whereName('referral_commission')->first();
        $transactionCount = Transaction::count();
        $paymentCount = Payment::count();
        $transaction = $this->createTransaction('-50', $referrer, PaymentMethod::WITHDRAW);

        $this->assertDatabaseCount(Transaction::class, $transactionCount + 1);
        $this->assertDatabaseCount(Payment::class, $paymentCount + 2);
        $this->assertDatabaseHas(Payment::class, [
            'parent_id' => $transaction->id,
            'commission_amount' => '0',
            'full_amount' => '5',
            'amount' => '5',
            'payment_type_id' => $type->id,
            'status' => PaymentStatus::CREATE,
            'method' => PaymentMethod::TOP_UP
        ]);
    }
}
