<?php

namespace App\Services;

use App\Dto\PaymentCreateDto;
use App\Models\Address;
use App\Models\Payment;

class PaymentService
{
    /**
     * @var PaymentCreateDto
     */
    private PaymentCreateDto $dto;

    /**
     * @param PaymentCreateDto $paymentCreateDto
     */
    public function __construct(PaymentCreateDto $paymentCreateDto)
    {
        $this->dto = $paymentCreateDto;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        if (!$commissionAmount = self::getCommissionAmount($this->dto->fullAmount)) {
            return false;
        }

        if (!self::createNewPayment($this->dto, $commissionAmount)) {
            return false;
        }

        return true;
    }

    /**
     * @param $fullAmount
     * @return float
     */
    private static function getCommissionAmount($fullAmount): float
    {
        return round($fullAmount * 0.01);
    }

    /**
     * @param $dto
     * @param $commissionAmount
     * @return bool
     */
    private static function createNewPayment($dto, $commissionAmount): bool
    {
        $payment = Payment::create([
            'user_id' => $dto->userId,
            'full_amount' => $dto->fullAmount,
            'amount' => round(bcsub($dto->fullAmount, $commissionAmount)),
            'commission_amount' => $commissionAmount,
            'type' => $dto->type,
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
