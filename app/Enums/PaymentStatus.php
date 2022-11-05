<?php
declare(strict_types=1);

namespace App\Enums;

class PaymentStatus
{
    public const CREATE = 5;
    public const PAID = 50;
    public const CANCEL = 10;
    public const EXPIRED = 20;

    public static array $list = [
        self::CREATE => 'create',
        self::PAID => 'paid',
        self::CANCEL => 'cancel',
        self::EXPIRED => 'expired',
    ];
}
