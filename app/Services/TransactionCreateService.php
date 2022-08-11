<?php

namespace App\Services;

use App\Dto\TransactionCreateDto;
use App\Enums\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

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
     * @return Transaction|bool
     */
    public function handle(): Transaction|bool
    {
        Log::channel('transaction')->info($this->dto->payment->id . ' - trying create new transaction');

        try {
            $transaction = $this->createTransaction();
            if ($transaction->exists()) {
                Log::channel('transaction')->info($this->dto->payment->id . ' - success transaction created');

                return $transaction;
            }

            return false;
        } catch (Exception $exception) {
            Log::channel('transaction')->error($this->dto->payment->id . ' - error transaction created');

            SystemNoticeService::createNotice(
                'Error transaction',
                'Error while create transaction for payment id: '
                . $this->dto->payment->id . '. Error message: ' . $exception->getMessage()
            );
        }

        return false;
    }

    /**
     * @return Transaction|bool
     * @throws Exception
     * @throws InvalidArgumentException
     */
    private function createTransaction(): Transaction|bool
    {
        try {
            $transaction = Transaction::create([
                'payment_id' => $this->dto->payment->id,
                'full_amount' => $this->dto->payment->full_amount,
                'amount' => $this->dto->payment->amount,
                'commission_amount' => $this->dto->payment->commission_amount,
                'new_balance' => $this->getNewBalance(),
                'old_balance' => $this->getOldBalance(),
            ]);

            if ($transaction->exists()) {
                Log::channel('transaction')->info($this->dto->payment->id . ' - transaction id: ' . $transaction->id);

                return $transaction;
            }

            return false;
        } catch (Exception $exception) {
            Log::channel('transaction')->info($this->dto->payment->id . ' - error while creating transaction');
            Log::channel('transaction')->info($exception->getMessage());
            Log::channel('transaction')->info($exception->getTraceAsString());

            $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));
            $bot->sendMessage(env('TELEGRAM_CHAT_ID'), 'Error while creating payment transaction. Payment id: ' . $this->dto->payment->id);

            SystemNoticeService::createNotice(
                'Error transaction',
                'Error while create transaction for payment id: '
                . $this->dto->payment->id . '. Error message: ' . $exception->getMessage()
            );
        }

        return false;
    }

    /**
     * @return string|null
     */
    private function getOldBalance(): null|string
    {
        return $this->dto->payment->user->balance;
    }

    /**
     * @return string|bool
     */
    private function getNewBalance(): string|bool
    {
        return $this->dto->payment->method === PaymentMethod::TOP_UP ?
            bcadd($this->getOldBalance(), $this->dto->payment->amount, 8) : // Top up amount without commission
            bcsub($this->getOldBalance(), abs($this->dto->payment->full_amount), 8); // Withdraw full amount
    }
}
