<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.statistic.general', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }

    /**
     * @return View
     */
    public function user(): View
    {
        $statistics = DB::table('users')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->paginate(30);

        return view('admin.statistic.user', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'statistics' => $statistics,
        ]);
    }

    /**
     * @return View
     */
    public function finance(): View
    {
        $statistics = DB::table('payments')
            ->select(
                DB::raw('DATE(paid_at) as date'),
                DB::raw('
                    (select sum(full_amount)
                        from payments
                        where DATE(paid_at) = date and
                              status = 50 and
                              method = 10) as full_amount_top_up,
                   (select sum(full_amount)
                    from payments
                    where DATE(paid_at) = date and
                            status = 50 and
                            method = 20) as full_amount_withdraw,
                   (select sum(amount)
                        from payments
                        where DATE(paid_at) = date and
                            status = 50 and
                            method = 10) as amount_top_up,
                   (select sum(amount)
                    from payments
                    where DATE(paid_at) = date and
                            status = 50 and
                            method = 20) as amount_withdraw,
                   (select sum(commission_amount)
                        from payments
                        where DATE(paid_at) = date) as commission_amount
                ')
            )
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->paginate(30);

        return view('admin.statistic.finance', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'statistics' => $statistics,
        ]);
    }
}
