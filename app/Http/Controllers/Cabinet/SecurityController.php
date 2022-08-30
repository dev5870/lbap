<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\SecurityUpdateRequest;
use App\Models\UserParam;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cabinet.user.security', [
            'params' => UserParam::firstOrCreate(['user_id' => Auth::id()]),
            'telegram' => Auth::user()->telegram()->first(),
        ]);
    }

    /**
     * @param SecurityUpdateRequest $request
     * @return RedirectResponse|View
     */
    public function update(SecurityUpdateRequest $request): RedirectResponse|View
    {
        if (empty($request->user()->telegram)) {
            return redirect()->route('cabinet.user.security')->with([
                'error-message' => __('title.error.update')
            ]);
        }

        $userParams = UserParam::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'mfa' => $request->has('mfa'),
                'login_notify' => $request->has('login_notify'),
            ]
        );

        return redirect()->route('cabinet.user.security')->with([
            'success-message' => __('title.success')
        ]);
    }
}
