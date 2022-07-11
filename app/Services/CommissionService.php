<?php

namespace App\Services;

use App\Models\Payment;

class CommissionService
{
    /**
     * @param Payment $payment
     * @return string
     */
    public static function getCommission(Payment $payment): string
    {
        return $payment->type->commission ?? config('balance.default_commission');
    }
}
