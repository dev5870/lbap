<?php

namespace App\Services;

use App\Models\Address;
use TelegramBot\Api\BotApi;

class AddressService
{
    /**
     * @return bool
     */
    public static function checkFreeAddress(): bool
    {
        if (self::getFreeAddress() <= 5) {
            SystemNoticeService::createNotice('Attention', 'Available address count');

            $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));
            $bot->sendMessage(env('TELEGRAM_CHAT_ID'), 'Available address count');
        }

        return true;
    }

    /**
     * @return int
     */
    public static function getFreeAddress(): int
    {
        return Address::whereNull('user_id')->count();
    }
}
