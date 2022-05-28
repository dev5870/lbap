<?php

namespace App\Services;

use App\Models\Address;

class AddressService
{
    /**
     * @return bool
     */
    public static function checkFreeAddress(): bool
    {
        if (self::getFreeAddress() <= 5) {
            SystemNoticeService::createNotice('Attention', 'Available address count');
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
