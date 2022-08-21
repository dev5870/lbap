<?php

namespace App\Http\Controllers;

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
        $setting->registration_method = $request->get('registration_method');
        $setting->invitation_only = $request->has('invitation_only');
        $setting->save();

        return redirect()->route('admin.settings.index')->with([
            'success-message' => __('title.success')
        ]);
    }
}
