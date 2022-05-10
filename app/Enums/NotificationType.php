<?php

namespace App\Enums;

class NotificationType
{
    public const PRIMARY = 10;
    public const SECONDARY = 11;
    public const SUCCESS = 12;
    public const DANGER = 13;
    public const WARNING = 14;
    public const INFO = 15;

    public static array $list = [
        self::PRIMARY => 'primary',
        self::SECONDARY => 'secondary',
        self::SUCCESS => 'success',
        self::DANGER => 'danger',
        self::WARNING => 'warning',
        self::INFO => 'info',
    ];
}
