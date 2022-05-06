<?php

namespace App\Enums;

class UserStatus
{
    public const ACTIVE = 10;
    public const BLOCKED = 20;

    public static array $list = [
        'active' => self::ACTIVE,
        'blocked' => self::BLOCKED,
    ];
}
