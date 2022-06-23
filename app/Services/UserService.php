<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\UserTelegram;
use Illuminate\Support\Facades\Auth;

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
     * @param $secretKey
     * @return bool
     */
    public static function isSecretKeyExists($secretKey): bool
    {
        return User::whereSecretKey($secretKey)->exists();
    }

    /**
     * @param $user
     * @return bool
     */
    public static function isMfaUser($user): bool
    {
        return (bool)$user->params?->mfa;
    }

    /**
     * @param $user
     * @param $code
     * @return bool
     */
    public static function isCorrectMfaCode($user, $code): bool
    {
        return $user->mfa?->code == $code ?? true;
    }

    /**
     * @param LoginRequest $request
     * @return void
     */
    public static function logout(LoginRequest $request): void
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
