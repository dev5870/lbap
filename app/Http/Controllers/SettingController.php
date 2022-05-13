<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.settings.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function general(Request $request): RedirectResponse
    {
        $setting = Setting::first();
        $setting->site_name = $request->get('site_name');
        $setting->commission_amount = $request->get('commission_amount');
        $setting->save();

        return redirect()->route('admin.settings.index')->with([
            'success-message' => __('title.success')
        ]);
    }
}
