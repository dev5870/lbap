<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TgController extends Controller
{
    public function index()
    {
        Log::channel('telegram')->info('Tg API init');

        try {
            $bot = new \TelegramBot\Api\Client(env('TELEGRAM_BOT_TOKEN'));
            $bot->command('ping', function ($message) use ($bot) {
                $bot->sendMessage($message->getChat()->getId(), 'pong!');
            });

            $bot->command('start', function ($message) use ($bot) {
                Log::channel('telegram')->info($message->getText());
                $bot->sendMessage($message->getChat()->getId(), __('title.bot.welcome'));
            });

            $bot->on(function (\TelegramBot\Api\Types\Update $update) use ($bot) {
                $message = $update->getMessage();

                // Check if user send email address
                if ($message && filter_var($message->getText(), FILTER_VALIDATE_EMAIL)) {
                    if ($this->isEmailExists($message->getText())) {
                        return false;
                    }

                    $password = $this->generateRandomString();
                    $user = User::create([
                        'email' => $message->getText(),
                        'password' => Hash::make($password)
                    ]);

                    if ($user) {
                        $bot->sendMessage(
                            $message->getChat()->getId(),
                            "Your email: " . $message->getText() . "\n" . "Your password: " . $password
                        );
                    }
                }
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
