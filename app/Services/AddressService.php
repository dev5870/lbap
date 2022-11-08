<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Address;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

class AddressService
{
    /**
     * @return bool
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public static function isFreeAddressExists(): bool
    {
        $freeAddress = self::countFreeAddress();

        if ($freeAddress <= config('address.minimal')) {
            SystemNoticeService::createNotice('Attention', 'Available address count: ' . $freeAddress);

            $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));
            $bot->sendMessage(env('TELEGRAM_CHAT_ID'), 'Available address count: ' . $freeAddress);
        }

        return true;
    }

    /**
     * @return int
     */
    public static function countFreeAddress(): int
    {
        return Address::whereNull('user_id')->count();
    }

    /**
     * @return Address|null
     */
    public static function getAddress(): Address|null
    {
        return Address::whereNull('user_id')->first();
    }
}
