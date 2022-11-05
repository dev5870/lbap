<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Filters\ReferralFilter;
use App\Models\Address;
use App\Models\Content;
use App\Models\Payment;
use App\Models\SystemNotice;
use App\Models\Transaction;
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
        $addresses = Address::orderBy('id', 'desc');

        return view('admin.dashboard', [
            'allAddresses' => $addresses->count(),
            'lastDayAddresses' => $addresses->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count(),
            'allContents' => $contents->count(),
            'lastDayContents' => $contents->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->count(),
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
            'referrals' => UserReferral::sortable(['id' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }

    /**
     * @return View
     */
    public function systemNotice(): View
    {
        return view('admin.notice.index', [
            'notices' => SystemNotice::sortable(['id' => 'desc'])->paginate(config('view.per_page')),
        ]);
    }

    /**
     * @return View
     */
    public function transaction(): View
    {
        return view('admin.transaction.index', [
            'transactions' => Transaction::sortable(['id' => 'desc'])->paginate(config('view.per_page')),
        ]);
    }
}
