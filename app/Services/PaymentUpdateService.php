<?php

namespace App\Services;

use App\Dto\PaymentUpdateDto;
use App\Dto\TransactionCreateDto;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
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
        if ($this->dto->payment->type == PaymentType::MINUS && ($this->isEnoughMoney() === false)) {
            return false;
        }

        if ($this->isClosePayment() === true) {
            return false;
        }

        if (($this->dto->status === PaymentStatus::CANCEL) && (self::canselPayment() === true)) {
            return true;
        }

        if (($this->dto->status === PaymentStatus::PAID) && (self::paidPayment() === true)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isEnoughMoney(): bool
    {
        return bccomp($this->dto->user->balance, $this->dto->payment->full_amount) >= 0;
    }

    /**
     * @return bool
     */
    private function canselPayment(): bool
    {
        $this->dto->payment->status = PaymentStatus::CANCEL;
        $this->dto->payment->admin_id = $this->dto->userAdmin->id;

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
        $this->dto->payment->admin_id = $this->dto->userAdmin->id;

        if ($this->dto->payment->save()) {
            $this->dto->payment->refresh();

            $transactionDto = new TransactionCreateDto();
            $transactionDto->payment = $this->dto->payment;
            (new TransactionCreateService($transactionDto))->handle();

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
