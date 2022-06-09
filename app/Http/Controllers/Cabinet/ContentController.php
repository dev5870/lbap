<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(): View
    {
        return view('cabinet.content.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }
}
