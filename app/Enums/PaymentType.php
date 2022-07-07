<?php

namespace App\Enums;

class PaymentType
{
    public const REAL_MONEY = 10;
    public const GIFT_MONEY = 20;
    public const REFERRAL_COMMISSION = 30;

    public static array $list = [
        self::REAL_MONEY => 'real money',
        self::GIFT_MONEY => 'gift money',
        self::REFERRAL_COMMISSION => 'referral commission',
    ];
}
