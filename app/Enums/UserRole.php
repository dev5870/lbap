<?php

namespace App\Enums;

class UserRole
{
    public const USER = 'user';
    public const EDITOR = 'editor';
    public const ADMIN = 'admin';

    public static array $list = [
        self::USER => self::USER,
        self::EDITOR => self::EDITOR,
        self::ADMIN => self::ADMIN,
    ];
}
