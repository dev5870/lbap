<?php

namespace App\Services;

use App\Http\Requests\PaymentCreateRequest;
use App\Models\Address;
use App\Models\Payment;

class PaymentService
{
    /**
     * @param PaymentCreateRequest $request
     * @return bool
     */
    public function handle(PaymentCreateRequest $request): bool
    {
        if (!$commissionAmount = self::getCommissionAmount($request->get('full_amount'))) {
            return false;
        }

        if (!self::createNewPayment($request, $commissionAmount, )) {
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
     * @param PaymentCreateRequest $request
     * @param $commissionAmount
     * @return bool
     */
    private static function createNewPayment(PaymentCreateRequest $request, $commissionAmount): bool
    {
        $payment = Payment::create([
            'user_id' => $request->get('user_id'),
            'full_amount' => $request->get('full_amount'),
            'amount' => round($request->get('full_amount') - $commissionAmount),
            'commission_amount' => $commissionAmount,
            'type' => $request->get('type'),
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
