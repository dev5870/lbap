<?php

namespace App\Http\Controllers;

use App\Http\Filters\ReferralFilter;
use App\Models\Content;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserReferral;
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
        $payments = Payment::orderBy('id', 'desc');

        return view('admin.dashboard', [
            'notifications' => Notification::all(),
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

    /**
     * @param Request $request
     * @return View
     */
    public function referral(Request $request): View
    {
        $filter = new ReferralFilter($request);

        return view('admin.user.referral.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'referrals' => UserReferral::sortable(['id' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }
}
