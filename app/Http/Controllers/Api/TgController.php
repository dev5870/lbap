<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserTelegram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TgController extends Controller
{
    public function index()
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

                // Check if user send email address
                if ($message && filter_var($message->getText(), FILTER_VALIDATE_EMAIL)) {

                    // Check if email already exists
                    if ($this->isEmailExists($message->getText())) {
                        return false;
                    }

                    // Check if chat id already exists
                    if ($this->isChatIdExists($message->getFrom()->getId())) {
                        return false;
                    }

                    DB::beginTransaction();

                    // Register new user
                    $password = $this->generateRandomString();
                    $user = User::create([
                        'email' => $message->getText(),
                        'password' => Hash::make($password)
                    ]);

                    // Create user telegram information
                    $userTelegram = UserTelegram::create([
                        'user_id' => $user->id,
                        'chat_id' => $message->getFrom()->getId(),
                        'username' => $message->getFrom()->getUsername(),
                        'firstName' => $message->getFrom()->getFirstName(),
                        'lastName' => $message->getFrom()->getLastName(),
                        'languageCode' => $message->getFrom()->getLanguageCode(),
                    ]);

                    if ($user && $userTelegram) {
                        $bot->sendMessage(
                            $message->getChat()->getId(),
                            "Your email: " . $message->getText() . "\n" . "Your password: " . $password
                        );
                        DB::commit();
                        return true;
                    } else {
                        DB::rollBack();
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
     * @param $email
     * @return bool
     */
    private function isEmailExists($email): bool
    {
        return User::where('email', '=', $email)->exists();
    }

    /**
     * @param $chatId
     * @return bool
     */
    private function isChatIdExists($chatId): bool
    {
        return UserTelegram::where('chat_id', '=', $chatId)->exists();
    }

    /**
     * @return string
     */
    private function generateRandomString(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
