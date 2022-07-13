<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class StatisticController extends Controller
{
    public function index()
    {
        return view('admin.statistic.general', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }

    public function user()
    {
        return view('admin.statistic.user', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }

    public function finance()
    {
        return view('admin.statistic.finance', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }
}
