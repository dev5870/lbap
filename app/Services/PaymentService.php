<?php

namespace App\Services;

use App\Dto\PaymentCreateDto;
use App\Enums\PaymentType;
use App\Models\Address;
use App\Models\Payment;

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
        if ($this->dto->type == PaymentType::MINUS && ($this->isEnoughMoney() === false)) {
            return false;
        }

        if (!$this->createNewPayment()) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    private function isEnoughMoney(): bool
    {
        return bccomp($this->dto->user->balance, $this->dto->fullAmount) >= 0;
    }

    /**
     * @return float
     */
    private function getCommissionAmount(): float
    {
        return round($this->dto->fullAmount * 0.01);
    }

    /**
     * @return bool
     */
    private function createNewPayment(): bool
    {
        $payment = Payment::create([
            'user_id' => $this->dto->user->id,
            'full_amount' => $this->dto->fullAmount,
            'amount' => round(bcsub($this->dto->fullAmount, $this->commissionAmount)),
            'commission_amount' => $this->commissionAmount,
            'type' => $this->dto->type,
        ]);

        if ($payment->exists()) {
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
