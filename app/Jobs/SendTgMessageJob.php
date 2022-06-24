<?php

namespace App\Jobs;

use App\Services\SystemNoticeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\BotApi;

class SendTgMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private $user, private $message)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));
            $bot->sendMessage(
                $this->user->telegram()->first()->chat_id,
                $this->message
            );
        } catch (\Exception $exception) {
            SystemNoticeService::createNotice('Error send tg message', $this->message . ' for user_id: ' . $this->user->id);
            Log::channel()->error('Error send tg message: ' . $this->message . ' for user_id: ' . $this->user->id);
            Log::channel()->error($exception->getMessage());
            Log::channel()->error($exception->getTraceAsString());
        }
    }
}
