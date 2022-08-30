<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserTelegram;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TgController extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        Log::channel('telegram')->info('Tg API: init');

        try {
            $bot = new \TelegramBot\Api\Client(env('TELEGRAM_BOT_TOKEN'));

            $bot->command('start', function ($message) use ($bot) {
                Log::channel('telegram')->info('Tg API: start block');
                Log::channel('telegram')->info(print_r($message->getFrom(), true));
                $bot->sendMessage($message->getChat()->getId(), __('title.bot.welcome'));
            });

            $bot->on(function (\TelegramBot\Api\Types\Update $update) use ($bot) {
                $message = $update->getMessage();

                Log::channel('telegram')->info('Tg API: update block');
                Log::channel('telegram')->info(print_r($message->getFrom(), true));

                // If message null
                if (!$message || !$message->getText()) {
                    Log::channel('telegram')->info('Tg API: message is null');

                    return false;
                }

                // Check if chat id already exists
                if (UserService::isChatIdExists($message->getFrom()->getId())) {
                    Log::channel('telegram')->info('Tg API: chat already exists');

                    return false;
                }

                // Check if user send email address
                if (filter_var($message->getText(), FILTER_VALIDATE_EMAIL)) {

                    // Check if email already exists
                    if (UserService::isEmailExists($message->getText())) {
                        Log::channel('telegram')->info('Tg API: email already exists');

                        return false;
                    }

                    // Register new user
                    $password = UserService::generateRandomString();
                    $user = User::create([
                        'email' => $message->getText(),
                        'password' => Hash::make($password)
                    ]);

                    // Create user telegram information
                    $userTelegram = $this->addUserTelegramInfo($message, $user);

                    if ($user && $userTelegram) {
                        $bot->sendMessage(
                            $message->getChat()->getId(),
                            __('title.bot.success_registration') . "\n" . __('title.bot.email') . $message->getText() . "\n" . __('title.bot.password') . $password
                        );

                        return true;
                    } else {

                        return false;
                    }
                }

                // Check if user send secret key
                if (strlen($message->getText()) == 8) {

                    // Check secret key exists
                    if (!UserService::isSecretKeyExists($message->getText())) {
                        Log::channel('telegram')->info('Tg API: error secret key');

                        return false;
                    }

                    $user = User::whereSecretKey($message->getText())->first();

                    // Create user telegram information
                    $userTelegram = $this->addUserTelegramInfo($message, $user);

                    if ($userTelegram) {
                        $bot->sendMessage(
                            $message->getChat()->getId(),
                            __('title.bot.success_login')
                        );

                        return true;
                    } else {

                        return false;
                    }
                }

                return true;

            }, function () {
                return true;
            });

            $bot->run();
        } catch (\Exception $e) {
            Log::channel('telegram')->info($e->getMessage());
        }
    }

    /**
     * @param $message
     * @param $user
     * @return bool
     */
    private function addUserTelegramInfo($message, $user): bool
    {
        $userTelegram = UserTelegram::create([
            'user_id' => $user->id,
            'chat_id' => $message->getFrom()->getId(),
            'username' => $message->getFrom()->getUsername(),
            'firstName' => $message->getFrom()->getFirstName(),
            'lastName' => $message->getFrom()->getLastName(),
            'languageCode' => $message->getFrom()->getLanguageCode(),
        ]);

        if ($userTelegram->exists()) {
            return true;
        }

        return false;
    }
}
