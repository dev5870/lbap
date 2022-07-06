<?php

namespace App\Services;

use App\Dto\PaymentCreateDto;
use App\Enums\PaymentType;
use App\Models\Address;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * @var PaymentCreateDto
     */
    private PaymentCreateDto $dto;
    private float $commissionAmount;

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
            if ($this->dto->type == PaymentType::MINUS && !$this->isEnoughMoney()) {
                Log::channel('payment')->error('create - user does not have money');

                return false;
            }

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
    private function isEnoughMoney(): bool
    {
        Log::channel('payment')->info('create - user balance: ' . $this->dto->user->balance);
        Log::channel('payment')->info('create - payment full amount: ' . $this->dto->fullAmount);

        return bccomp($this->dto->user->balance, $this->dto->fullAmount, 8) >= 0;
    }

    /**
     * @return float
     */
    private function getCommissionAmount(): float
    {
        return bcmul($this->dto->fullAmount, '0.01', 8);
    }

    /**
     * @return bool
     */
    private function createNewPayment(): bool
    {
        $payment = Payment::create([
            'user_id' => $this->dto->user->id,
            'full_amount' => $this->dto->fullAmount,
            'amount' => bcsub($this->dto->fullAmount, $this->commissionAmount, 8),
            'commission_amount' => $this->commissionAmount,
            'type' => $this->dto->type,
        ]);

        if ($payment->exists()) {
            Log::channel('payment')->info('create - payment created. Payment id: ' . $payment->id);

            return true;
        }

        return false;
    }

    /**
     * @return Address|bool
     */
    public static function getAddress(): Address|bool
    {
        return Address::whereNull('user_id')->first() ?? false;
    }
}
