<?php

namespace App\Services;

use App\Models\PaymentType;

class CommissionService
{
    /**
     * System commission
     *
     * @param string $type
     * @return string
     */
    public static function getPercentCommission(string $type): string
    {
        $paymentType = PaymentType::find($type);

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
