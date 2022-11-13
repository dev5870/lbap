<?php

namespace App\Console\Commands;

use App\Services\PaymentCheckService;
use Illuminate\Console\Command;

class CheckNewPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:new-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check new user payments';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle(): int
    {
        $paymentCheckService = app(PaymentCheckService::class);
        $paymentCheckService->handle();

        return Command::SUCCESS;
    }
}
