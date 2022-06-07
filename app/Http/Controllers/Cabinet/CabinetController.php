<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Content;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserUserAgent;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('id', 'desc');
        $contents = Content::orderBy('id', 'desc');
        $payments = Payment::orderBy('id', 'desc');
        $addresses = Address::orderBy('id', 'desc');

        return view('cabinet.index', [
            'notifications' => Notification::all(),
            'allAddresses' => $addresses->count(),
            'lastDayAddresses' => $addresses->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count(),
            'allContents' => $contents->count(),
            'lastDayContents' => $contents->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count(),
            'settings' => Setting::first(),
            'users' => $users->take(5)->get(),
            'allUser' => $users->count(),
            'allPayment' => $payments->count(),
            'lastDayPayment' => $payments->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count(),
            'lastDay' => $users->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count(),
            'logs' => UserUserAgent::where('user_id', '=', Auth::id())->sortable(['created_at' => 'desc'])->take(5)->get(),
        ]);
    }
}