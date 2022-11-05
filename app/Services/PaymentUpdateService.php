<?php
declare(strict_types=1);

namespace App\Services;

use App\Dto\PaymentUpdateDto;
use App\Dto\TransactionCreateDto;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentUpdateService
{
    /**
     * @var PaymentUpdateDto
     */
    private PaymentUpdateDto $dto;

    public function __construct(private TransactionCreateService $transactionCreateService)
    {
    }

    /**
     * @param PaymentUpdateDto $paymentUpdateDto
     * @return bool
     */
    public function handle(PaymentUpdateDto $paymentUpdateDto): bool
    {
        $this->dto = $paymentUpdateDto;

        Log::channel('payment')->info('update - trying payment update ' . $this->dto->payment->id);

        try {
            if (!$this->dto->userAdmin->hasRole('admin')) {
                Log::channel('payment')->error('update - user does not have permission');

                return false;
            }

            if ($this->dto->status === PaymentStatus::CANCEL && $this->canselPayment()) {
                Log::channel('payment')->info('update - success payment canceled ' . $this->dto->payment->id);

                return true;
            }

            if ($this->dto->payment->method == PaymentMethod::WITHDRAW && !$this->isEnoughMoney()) {
                Log::channel('payment')->error('update - can not update, user does not have money ' . $this->dto->payment->id);

                return false;
            }

            if ($this->isClosePayment()) {
                Log::channel('payment')->error('update - can not update, payment already closed ' . $this->dto->payment->id);

                return false;
            }

            if ($this->dto->status === PaymentStatus::PAID && $this->paidPayment()) {
                Log::channel('payment')->info('update - success payment paid ' . $this->dto->payment->id);

                return true;
            }
        } catch (Exception $exception) {
            Log::channel('payment')->error('update - error while updating payment ' . $this->dto->payment->id);
            Log::channel('payment')->error($exception->getMessage());
            Log::channel('payment')->error($exception->getTraceAsString());
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isEnoughMoney(): bool
    {
        return bccomp(
            $this->dto->user->balance,
            (string)abs((int)$this->dto->payment->full_amount)
            ) >= 0;
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
        $this->dto->payment->paid_at = now();
        $this->dto->payment->admin_id = $this->dto->userAdmin->id;

        if ($this->dto->payment->save()) {
            $this->dto->payment->refresh();

            $transactionDto = new TransactionCreateDto();
            $transactionDto->payment = $this->dto->payment;
            $this->transactionCreateService->handle($transactionDto);

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
