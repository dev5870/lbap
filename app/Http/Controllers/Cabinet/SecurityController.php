<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\SecurityUpdateRequest;
use App\Models\UserParam;
use Illuminate\Contracts\View\View;
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
     * @return View
     */
    public function update(SecurityUpdateRequest $request): View
    {
        $userParams = UserParam::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'mfa' => $request->has('mfa'),
                'login_notify' => $request->has('login_notify'),
            ]
        );

        return view('cabinet.user.security', [
            'params' => $userParams,
            'telegram' => Auth::user()->telegram()->first(),
        ]);
    }
}
