<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\SecurityUpdateRequest;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class SecurityController extends Controller
{
    public function index(): View
    {
        return view('cabinet.user.security', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }

    public function update(SecurityUpdateRequest $request): View
    {
dd($request);
        return view('cabinet.user.security', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }
}
