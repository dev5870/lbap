<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class TgController extends Controller
{
    public function index()
    {
        Log::channel('telegram')->info('Tg API init');
    }

}
