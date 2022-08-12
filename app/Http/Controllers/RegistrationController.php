<?php

namespace App\Http\Controllers;

use App\Enums\RegistrationMethod;
use App\Http\Requests\RegistrationRequest;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserParam;
use App\Models\UserReferral;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    /**
     * @return View
     */
    public function create(): View
    {
        $settings = Setting::first();

        if ($settings->registration_method == RegistrationMethod::SITE) {
            return view('registration.site');
        } elseif ($settings->registration_method == RegistrationMethod::TELEGRAM) {
            return view('registration.telegram', [
                'url' => env('TELEGRAM_BOT_URL')
            ]);
        }

        return view('registration.disabled');
    }

    /**
     * @param RegistrationRequest $request
     * @return RedirectResponse
     */
    public function store(RegistrationRequest $request): RedirectResponse
    {
        $referrerParams = null;

        if ($request->has('invite')) {
            $referrerParams = UserParam::whereUserUuid($request->get('invite'))->first();
        }

        $user = User::create([
            'referrer' => $referrerParams->user_id ?? null,
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);

        if ($user->referrer) {
            UserReferral::create([
                'user_id' => $user->referrer,
                'referral_id' => $user->id,
            ]);
        }

        if ($user) {
            return redirect()->route('login.create')->with([
                'success-message' => __('title.registration.success')
            ]);
        }

        return redirect()->route('registration.create')->with([
            'error-message' => __('title.registration.error')
        ]);
    }
}
