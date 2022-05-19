<?php

namespace App\Enums;

class PaymentType
{
    public const TOP_UP = 10;
    public const MINUS = 20;

    public static array $list = [
        self::TOP_UP => 'top up',
        self::MINUS => 'minus',
    ];
}
