<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Filters\LogFilter;
use App\Models\Notification;
use App\Models\PaymentType;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserUserAgent;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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

    /**
     * @return View
     */
    public function referral(): View
    {
        $user = User::where('id', '=', Auth::id())
            ->with([
                'referrals',
                'payments',
                'params',
            ])
            ->first();

        $referralPaymentType = PaymentType::whereName('referral_commission')->first();

        return view('cabinet.user.referral.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'referrals' => User::whereReferrer(Auth::id())
                ->sortable(['created_at' => 'desc'])
                ->paginate(config('view.per_page')),
            'link' => UserService::getUserReferralLink($user),
            'totalReferrals' => count($user->referrals),
            'totalPaidAmount' => $user->payments()
                ->where('payment_type_id', '=', $referralPaymentType->id)
                ->whereNotNull('paid_at')
                ->sum('full_amount')
        ]);
    }
}
