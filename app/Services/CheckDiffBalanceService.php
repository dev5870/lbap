<?php

namespace App\Services;

use App\Models\User;

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
                SystemNoticeService::createNotice('Diff balance', 'User id: ' . $user->id);
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
            $this->getUserTransactionSum($user)
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
