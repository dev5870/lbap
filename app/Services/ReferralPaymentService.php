<?php

namespace App\Services;

use App\Dto\PaymentCreateDto;
use App\Enums\PaymentMethod;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class ReferralPaymentService
{
    private PaymentType $type;

    public function __construct(private Transaction $transaction)
    {
        $this->type = PaymentType::whereName('referral_commission')->first();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        Log::channel('payment')->info('create (referral payment) - trying create new payment');
        Log::channel('payment')->info('create (referral payment) - transaction id: ' . $this->transaction->id);

        try {
            // If transaction does not top up
            if ($this->transaction->payment->method != PaymentMethod::TOP_UP) {
                Log::channel('payment')->info('create (referral payment) - transaction does not top up method');

                return;
            }

            // If transaction does not have commission
            if (bccomp($this->transaction->commission_amount, '0', 8) <= 0) {
                Log::channel('payment')->info('create (referral payment) - transaction does not have commission');

                return;
            }

            // If transaction user not referral
            if (UserService::isReferralUser($this->transaction->payment->user) === false) {
                Log::channel('payment')->info('create (referral payment) - transaction user not referral');

                return;
            }

            // If commission already paid referrer
            if ($this->isParentTransactionExists()) {
                Log::channel('payment')->info('create (referral payment) - this commission already paid');

                return;
            }

            // If referrer commission more than 0.00000001
            if (bccomp($this->getReferrerCommissionFullAmount(), '0.00000001', 8) < 0) {
                Log::channel('payment')->info('create (referral payment) - referrer commission less than 0.00000001');

                return;
            }

            // If create payment
            if ($this->createPayment()) {
                Log::channel('payment')->info('create (referral payment) - success referral payment created');

                return;
            }

            Log::channel('payment')->error('create (referral payment) - error referral payment created');

            return;
        } catch (Exception $exception) {
            Log::channel('payment')->error('create (referral payment) - error while creating new payment');
            Log::channel('payment')->error($exception->getMessage());
            Log::channel('payment')->error($exception->getTraceAsString());
        }

    }

    /**
     * @return bool
     */
    private function isParentTransactionExists(): bool
    {
        return Payment::where('parent_id', '=', $this->transaction->id)
            ->where('payment_type_id', '=', $this->type->id)
            ->exists();
    }

    /**
     * @return bool
     */
    private function createPayment(): bool
    {
        $dto = new PaymentCreateDto();
        $dto->user = User::find($this->transaction->payment->user->referrer);
        $dto->type = $this->type->id;
        $dto->method = PaymentMethod::TOP_UP;
        $dto->fullAmount = $this->getReferrerCommissionFullAmount();
        $dto->parentId = $this->transaction->id;

        if ((new PaymentService($dto))->handle()) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    private function getReferrerCommissionFullAmount(): string
    {
        return bcmul(
            $this->transaction->commission_amount,
            CommissionService::getReferralCommission(),
            8
        );
    }
}
