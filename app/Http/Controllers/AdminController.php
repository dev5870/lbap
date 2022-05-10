<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserUserAgent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function dashboard(): View
    {
        $users = User::orderBy('id', 'desc');
        $contents = Content::orderBy('id', 'desc');

        return view('admin.dashboard', [
            'notifications' => Notification::all(),
            'allContents' => $contents->count(),
            'lastDayContents' => $contents->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count(),
            'settings' => Setting::first(),
            'users' => $users->take(5)->get(),
            'allUser' => $users->count(),
            'lastDay' => $users->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count(),
            'logs' => UserUserAgent::where('user_id', '=', Auth::id())->sortable(['created_at' => 'desc'])->take(5)->get(),
        ]);
    }
}
