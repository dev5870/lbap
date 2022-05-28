<?php

namespace App\Services;

use App\Dto\PaymentUpdateDto;
use App\Enums\PaymentStatus;
use Carbon\Carbon;

class PaymentUpdateService
{
    /**
     * @var PaymentUpdateDto
     */
    private PaymentUpdateDto $dto;

    /**
     * @param PaymentUpdateDto $paymentUpdateDto
     */
    public function __construct(PaymentUpdateDto $paymentUpdateDto)
    {
        $this->dto = $paymentUpdateDto;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        if ($this->isClosePayment()) {
            return false;
        }

        if ((
            $this->dto->status === PaymentStatus::CANCEL
        ) &&
            self::canselPayment()
        ) {
            return true;
        }

        if ((
            $this->dto->status === PaymentStatus::PAID
        ) &&
            self::paidPayment()
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function canselPayment(): bool
    {
        $this->dto->payment->status = PaymentStatus::CANCEL;

        if ($this->dto->payment->save()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function paidPayment(): bool
    {
        $this->dto->payment->status = PaymentStatus::PAID;
        $this->dto->payment->paid_at = Carbon::now();

        if ($this->dto->payment->save()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isClosePayment(): bool
    {
        return ($this->dto->payment->status === PaymentStatus::PAID ||
            $this->dto->payment->status === PaymentStatus::EXPIRED ||
            $this->dto->payment->status === PaymentStatus::CANCEL);
    }
}
