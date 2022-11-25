<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\PaymentType;

class CommissionService
{
    /**
     * System commission
     *
     * @param int $type
     * @return string
     */
    public function getPercentCommission(int $type): string
    {
        $paymentType = PaymentType::find($type);

        if ($paymentType?->name === 'real_money') {

            return $paymentType ? $paymentType->commission : config('balance.default_commission');
        }

        return '0';
    }

    /**
     * @return string
     */
    public function getReferralCommission(): string
    {
        $paymentType = PaymentType::whereName('referral_commission')->first();

        return $paymentType ? $paymentType->commission : config('balance.default_commission');
    }
}
