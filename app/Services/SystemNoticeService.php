<?php

namespace App\Services;

use App\Models\SystemNotice;

class SystemNoticeService
{
    /**
     * @param $title
     * @param $description
     * @return bool
     */
    public static function createNotice($title, $description): bool
    {
        $message = SystemNotice::create([
            'title' => $title,
            'description' => $description,
        ]);

        return $message->exists();
    }
}
