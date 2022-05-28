<?php

namespace App\Services;

use App\Dto\TransactionCreateDto;
use App\Enums\PaymentType;
use App\Models\Transaction;
use App\Models\User;

class TransactionCreateService
{
    /**
     * @var TransactionCreateDto
     */
    private TransactionCreateDto $dto;

    /**
     * @param TransactionCreateDto $transactionCreateDto
     */
    public function __construct(TransactionCreateDto $transactionCreateDto)
    {
        $this->dto = $transactionCreateDto;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        if ($this->createTransaction() === true) {
            return true;
        }

        SystemNoticeService::createNotice(
            'Error transaction',
            'Error while create transaction for payment id: ' . $this->dto->payment->id
        );

        return false;
    }

    /**
     * @return bool
     */
    private function createTransaction(): bool
    {
        $transaction = Transaction::create([
            'payment_id' => $this->dto->payment->id,
            'full_amount' => $this->dto->payment->full_amount,
            'amount' => $this->dto->payment->amount,
            'commission_amount' => $this->dto->payment->commission_amount,
            'new_balance' => $this->getNewBalance(),
            'old_balance' => $this->getOldBalance(),
        ]);

        if ($transaction->exists()) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    private function getOldBalance(): mixed
    {
        return User::find($this->dto->payment->user_id)->balance;
    }

    /**
     * @return mixed
     */
    private function getNewBalance(): mixed
    {
        if ($this->dto->payment->type === PaymentType::TOP_UP) {
            return bcadd($this->getOldBalance(), $this->dto->payment->amount);
        } elseif ($this->dto->payment->type === PaymentType::MINUS) {
            return bcsub($this->getOldBalance(), $this->dto->payment->full_amount);
        }

        return false;
    }


}
