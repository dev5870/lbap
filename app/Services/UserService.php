<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserTelegram;

class UserService
{
    /**
     * @return string
     */
    public static function generateRandomString(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param $email
     * @return bool
     */
    public static function isEmailExists($email): bool
    {
        return User::where('email', '=', $email)->exists();
    }

    /**
     * @param $chatId
     * @return bool
     */
    public static function isChatIdExists($chatId): bool
    {
        return UserTelegram::where('chat_id', '=', $chatId)->exists();
    }

    /**
     * @return bool
     */
    public static function isSecretKeyExists($secretKey): bool
    {
        return User::whereSecretKey($secretKey)->exists();
    }
}
