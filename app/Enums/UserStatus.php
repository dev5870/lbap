<?php

namespace App\Enums;

class UserStatus
{
    public const ACTIVE = 10;
    public const BLOCKED = 20;

    public static array $list = [
        self::ACTIVE => 'active',
        self::BLOCKED => 'blocked',
    ];
}
