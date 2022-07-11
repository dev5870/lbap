<?php

namespace App\Services;

use App\Dto\PaymentCreateDto;
use App\Models\PaymentType;

class CommissionService
{
    /**
     * System commission
     *
     * @param PaymentCreateDto $dto
     * @return string
     */
    public static function getPercentCommission(PaymentCreateDto $dto): string
    {
        $paymentType = PaymentType::find($dto->type);

        if ($paymentType->name == 'real_money') {

            return $paymentType ? $paymentType->commission : config('balance.default_commission');
        }

        return '0';
    }

    /**
     * @return string
     */
    public static function getReferralCommission(): string
    {
        $paymentType = PaymentType::whereName('referral_commission')->first();

        return $paymentType ? $paymentType->commission : config('balance.default_commission');
    }
}
