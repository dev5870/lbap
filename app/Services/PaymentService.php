<?php

namespace App\Services;

use App\Dto\PaymentCreateDto;
use App\Enums\PaymentMethod;
use App\Models\Payment;
use App\Models\PaymentType;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    private PaymentCreateDto $dto;
    private string $commissionAmount;
    private string $checkAddressUrl = 'https://dogechain.info/api/v1/address/balance/';

    /**
     * @param PaymentCreateDto $paymentCreateDto
     */
    public function __construct(PaymentCreateDto $paymentCreateDto)
    {
        $this->dto = $paymentCreateDto;
        $this->commissionAmount = $this->getCommissionAmount();
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        Log::channel('payment')->info('create - trying create new payment');
        Log::channel('payment')->info('create - payment type: ' . $this->dto->type);

        try {
            // Check address valid
            if ($this->dto->address !== null && !$this->checkAddress()) {
                Log::channel('payment')->error('create - invalid address: ' . $this->dto->address);

                return false;
            }

            // If initiator not equal recipient or not admin
            if ($this->dto->userInitiator &&
                $this->dto->userInitiator->id != $this->dto->user->id &&
                !$this->dto->userInitiator->hasRole('admin')
            ) {
                Log::channel('payment')->error('create - user does not have permission');

                return false;
            }

            // If withdraw and user does not have money
            if ($this->dto->method == PaymentMethod::WITHDRAW && !$this->isEnoughMoney()) {
                Log::channel('payment')->error('create - user does not have money');

                return false;
            }

            // If can't create payment
            if (!$this->createNewPayment()) {
                Log::channel('payment')->error('create - can not create new payment');

                return false;
            }

            return true;
        } catch (Exception $exception) {
            Log::channel('payment')->error('create - error while creating new payment');
            Log::channel('payment')->error($exception->getMessage());
            Log::channel('payment')->error($exception->getTraceAsString());
        }

        return false;
    }

    /**
     * @return bool
     */
    private function checkAddress(): bool
    {
        $response = Http::get($this->checkAddressUrl . $this->dto->address)->json();

        if (isset($response['success']) && $response['success'] == 1) {

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isEnoughMoney(): bool
    {
        Log::channel('payment')->info('create - user balance: ' . $this->dto->user->balance);
        Log::channel('payment')->info('create - payment full amount: ' . $this->dto->fullAmount);

        return bccomp($this->dto->user->balance, $this->dto->fullAmount, 8) >= 0;
    }

    /**
     * @return float
     */
    private function getCommissionAmount(): string
    {
        return bcmul(
            $this->dto->fullAmount,
            CommissionService::getPercentCommission($this->dto),
            8
        );
    }

    /**
     * @return bool
     */
    private function createNewPayment(): bool
    {
        $amount = bcsub($this->dto->fullAmount, $this->commissionAmount, 8);
        $fullAmount = $this->dto->fullAmount;
        $commission = $this->commissionAmount;

        if ($this->dto->method == PaymentMethod::WITHDRAW) {
            $fullAmount = bcmul(
                -1,
                $this->dto->fullAmount,
                8
            );

            $amount = bcmul(
                -1,
                bcsub($this->dto->fullAmount, $this->commissionAmount, 8),
                8
            );

            $commission = bcmul(
                -1,
                $this->commissionAmount,
                8
            );
        }

        $payment = Payment::create([
            'user_id' => $this->dto->user->id,
            'full_amount' => $fullAmount,
            'amount' => $amount,
            'commission_amount' => $commission,
            'payment_type_id' => $this->dto->type,
            'method' => $this->dto->method,
            'description' => $this->getDescription(),
            'txid' => $this->dto->txid,
            'parent_id' => $this->dto->parentId,
        ]);

        if ($payment->exists()) {
            Log::channel('payment')->info('create - payment created. Payment id: ' . $payment->id);

            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    private function getDescription(): string
    {
        return $this->dto->method == PaymentMethod::TOP_UP ?
            __('title.payment.description.top_up') :
            __('title.payment.description.withdraw') . ' ' . $this->dto->address;
    }

    /**
     * @return bool
     */
    private function isReferralPayment(): bool
    {
        $referralPaymentType = PaymentType::whereName('referral_commission')->first();

        return ($referralPaymentType->id != $this->dto->type);
    }
}
