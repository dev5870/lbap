<?php

namespace App\Enums;

class ContentStatus
{
    public const AWAITING_PUBLICATION = 5;
    public const PUBLISHED = 10;

    public static array $list = [
        self::AWAITING_PUBLICATION => 'awaiting publication',
        self::PUBLISHED => 'published',
    ];
}
