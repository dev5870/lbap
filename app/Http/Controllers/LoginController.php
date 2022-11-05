<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Jobs\SendTgMessageJob;
use App\Models\UserTelegramCode;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
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

        // If user enable mfa auth and dont send mfa code
        if (UserService::isMfaUser(Auth::user()) && !$request->has('code')) {
            $code = UserTelegramCode::updateOrCreate(
                ['user_id' => Auth::id()],
                ['code' => rand(0000, 9999)],
            );

            SendTgMessageJob::dispatch(Auth::user(), $code->code);
            UserService::logout($request);

            return redirect()->route('login.create', ['mfa'])->with([
                'error-message' => __('title.error.2fa')
            ]);
        }

        // If user enable mfa auth and send incorrect mfa code
        if (
            UserService::isMfaUser(Auth::user()) &&
            $request->has('code') &&
            !UserService::isCorrectMfaCode(Auth::user(), $request->get('code'))
        ) {
            UserService::logout($request);

            return redirect()->route('login.create', ['mfa'])->with([
                'error-message' => __('title.error.2fa')
            ]);
        }

        Auth::user()->mfa()?->delete();

        // Send telegram notify when user login
        if (Auth::user()?->telegram()->exists() && Auth::user()->params()->first()->login_notify) {
            SendTgMessageJob::dispatch(Auth::user(), __('cabinet.notify.login'));
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
