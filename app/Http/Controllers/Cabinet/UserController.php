<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Filters\LogFilter;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\UserUserAgent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function profile(): View
    {
        return view('cabinet.user.profile', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function log(Request $request): View
    {
        $filter = new LogFilter($request);

        return view('cabinet.user.log.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'logs' => UserUserAgent::whereUserId(Auth::id())->sortable(['created_at' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }
}
