<?php

namespace App\Console\Commands;

use App\Services\CheckDiffBalanceService;
use Illuminate\Console\Command;

class CheckDiffUserBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:diff-user-balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check diff user balances';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        (new CheckDiffBalanceService())->handle();

        return Command::SUCCESS;
    }
}
