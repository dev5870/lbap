<?php
declare(strict_types=1);

namespace App\Enums;

class NotificationStatus
{
    public const ACTIVE = 10;
    public const INACTIVE = 20;

    public static array $list = [
        self::ACTIVE => 'active',
        self::INACTIVE => 'inactive',
    ];
}
