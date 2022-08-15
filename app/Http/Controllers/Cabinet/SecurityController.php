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
        return view('cabinet.user.security', [
            'params' => UserParam::whereUserId(Auth::id())->first(),
            'telegram' => Auth::user()->telegram()->first(),
        ]);
    }
}
