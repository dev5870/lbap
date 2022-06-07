<?php

namespace App\Enums;

class RegistrationMethod
{
    public const SITE = 10;
    public const TELEGRAM = 20;

    public static array $list = [
        self::SITE => 'site',
        self::TELEGRAM => 'telegram',
    ];
}
