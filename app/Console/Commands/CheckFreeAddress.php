<?php

namespace App\Console\Commands;

use App\Services\AddressService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\Exception;

class CheckFreeAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:free-address';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check free address (without user)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            AddressService::isFreeAddressExists();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            Log::error($exception->getTraceAsString());
        }

        return Command::SUCCESS;
    }
}
