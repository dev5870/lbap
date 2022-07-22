<?php

namespace App\Enums;

class PaymentMethod
{
    public const TOP_UP = 10;
    public const WITHDRAW = 20;

    public static array $list = [
        self::TOP_UP => 'top up',
        self::WITHDRAW => 'withdraw',
    ];
}
