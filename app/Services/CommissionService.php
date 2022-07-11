<?php

namespace App\Services;

use App\Dto\PaymentCreateDto;
use App\Models\PaymentType;

class CommissionService
{
    /**
     * @param PaymentCreateDto $dto
     * @return string
     */
    public static function getPercentCommission(PaymentCreateDto $dto): string
    {
        $paymentType = PaymentType::find($dto->type);

        return $paymentType ? $paymentType->commission : config('balance.default_commission');
    }
}
