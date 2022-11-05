<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\BotApi;

class CheckDiffBalanceService
{
    /**
     * @return bool
     */
    public function handle(): bool
    {
        $users = User::with('transactions')->select(['id', 'balance'])->get();

        foreach ($users as $user) {
            if (!$this->isCorrect($user)) {
                try {
                    SystemNoticeService::createNotice(
                        'Diff balance',
                        'User id: ' . $user->id . ', balance: ' . $user->balance . ', transactions sum: ' . $user->transactions->sum('amount')
                    );

                    $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));
                    $bot->sendMessage(env('TELEGRAM_CHAT_ID'), 'User diff balance. User id: ' . $user->id);
                } catch (Exception $exception) {
                    Log::channel('different-balance')->error($exception->getMessage());
                    Log::channel('different-balance')->error($exception->getTraceAsString());
                }
            }
        }

        return true;
    }

    /**
     * @param $user
     * @return bool
     */
    private function isCorrect($user): bool
    {
        return bccomp(
            $user->balance,
            $this->getUserTransactionSum($user),
            8
        ) == 0;
    }

    /**
     * @param $user
     * @return mixed
     */
    private function getUserTransactionSum($user): mixed
    {
        return $user->transactions->sum('amount');
    }
}
