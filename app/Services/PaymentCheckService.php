<?php

namespace App\Services;

use App\Dto\PaymentCreateDto;
use App\Dto\TransactionCreateDto;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Address;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use TelegramBot\Api\BotApi;

class PaymentCheckService
{
    /**
     * @var string
     */
    private string $url = 'https://chain.so/api/v2/get_tx_received/DOGE/';

    /**
     * @return void
     */
    public function handle(): void
    {
        $addresses = $this->getAddresses();

        Log::channel('payment-check')->info('Start checking payments');
        Log::channel('payment-check')->info('Addresses for check: ' . count($addresses));

        // If addresses empty
        if ($addresses->count() < 1) {
            Log::channel('payment-check')->info('Does not have available addresses for check');

            return;
        }

        // Check each address
        $addresses->each(function ($address) {
            Log::channel('payment-check')->info('Check: ' . $address->address);

            // Get transactions by address
            $response = $this->getTransaction($address->address);

            // Return and check next address if can not get success response
            if (!isset($response['status']) || $response['status'] != 'success') {
                Log::channel('payment-check')->info('Can\'t get transactions');

                return true;
            }

            // Stop checking if can not add new transaction
            if (!$this->checkTransactions($response)) {
                Log::channel('payment-check')->error('Can\'t add new transactions');

                return false;
            }

            return true;
        });
    }

    /**
     * @return Collection
     */
    private function getAddresses(): Collection
    {
        return Address::whereNotNull('user_id')->get();
    }

    /**
     * @param string $address
     * @return array
     */
    private function getTransaction(string $address): array
    {
        $response = Http::get($this->url . $address);

        return $response->json();
    }

    /**
     * @param array $response
     * @return bool
     */
    private function checkTransactions(array $response): bool
    {
        if (empty($response['data']['txs'])) {
            Log::channel('payment-check')->info('Address does not have any transaction');

            return true;
        }

        foreach ($response['data']['txs'] as $transaction) {
            if (!$this->isTransactionExists($transaction['txid']) && $transaction['confirmations'] > config('balance.confirmation')) {
                Log::channel('payment-check')->info('Trying add new transaction txid: ' . $transaction['txid']);

                $newTransaction = $this->addNewTransaction($transaction, $response['data']['address']);
                if ($newTransaction instanceof Transaction) {
                    Log::channel('payment-check')->info('Success add new transaction!');

                    $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));
                    $bot->sendMessage(
                        env('TELEGRAM_CHAT_ID'),
                        'User id: ' . $newTransaction->payment->user_id .
                        ' Top up amount: ' . $newTransaction->amount .
                        ' Old balance: ' . $newTransaction->old_balance .
                        ' New balance: ' . $newTransaction->new_balance
                    );
                }
            }
        }

        return true;
    }

    /**
     * @param string $txid
     * @return bool
     */
    private function isTransactionExists(string $txid): bool
    {
        return Payment::where('txid', '=', $txid)->exists();
    }

    /**
     * @param array $transaction
     * @param string $address
     * @return Transaction|bool
     */
    private function addNewTransaction(array $transaction, string $address): Transaction|bool
    {
        DB::beginTransaction();

        try {
            // Create paid payment
            $payment = $this->createPayment($transaction, $address);
            if (!$payment) {
                throw new Exception('Error while creating payment');
            }

            // Create transaction
            $newTransaction = $this->createTransaction($payment);
            if (!$newTransaction) {
                throw new Exception('Error while creating transaction');
            }

            DB::commit();

            return $newTransaction;
        } catch (Exception $exception) {
            Log::channel('payment-check')->error('Error while creating new transaction');
            Log::channel('payment-check')->info($exception->getMessage());
            Log::channel('payment-check')->info($exception->getTraceAsString());
        }

        DB::rollBack();

        return false;
    }

    /**
     * @param array $transaction
     * @param string $address
     * @return Payment|bool
     */
    private function createPayment(array $transaction, string $address): Payment|bool
    {
        $paymentType = PaymentType::whereName('real_money')->first();
        $user = $this->getUserByAddress($address);

        $paymentCreateDto = new PaymentCreateDto();
        $paymentCreateDto->user = $user;
        $paymentCreateDto->userInitiator = $user;
        $paymentCreateDto->type = $paymentType->id;
        $paymentCreateDto->method = PaymentMethod::TOP_UP;
        $paymentCreateDto->address = $address;
        $paymentCreateDto->fullAmount = $transaction['value'];
        $paymentCreateDto->status = PaymentStatus::PAID;
        $paymentCreateDto->txid = $transaction['txid'];
        $paymentCreateDto->paidAt = now();

        $paymentService = new PaymentService($paymentCreateDto);

        return $paymentService->handle();
    }

    /**
     * @param Payment $payment
     * @return Transaction|bool
     */
    private function createTransaction(Payment $payment): Transaction|bool
    {
        $transactionDto = new TransactionCreateDto();
        $transactionDto->payment = $payment;

        $transactionService = new TransactionCreateService($transactionDto);

        return $transactionService->handle();
    }

    /**
     * @param string $address
     * @return User
     */
    private function getUserByAddress(string $address): User
    {
        $address = Address::whereAddress($address)->first();

        return User::find($address->user_id);
    }
}
