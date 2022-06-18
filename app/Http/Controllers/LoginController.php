<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Jobs\NewLoginNotifyJob;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use TelegramBot\Api\Exception;
use TelegramBot\Api\InvalidArgumentException;

class LoginController extends Controller
{
    /**
     * @return View
     */
    public function create(): View
    {
        return view('login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse|ValidationException
     * @throws ValidationException
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function store(LoginRequest $request): RedirectResponse|ValidationException
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Send telegram notify when user login
        if (Auth::user()->telegram()->exists() && Auth::user()->params()->first()->login_notify) {
            NewLoginNotifyJob::dispatch(Auth::user());
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
