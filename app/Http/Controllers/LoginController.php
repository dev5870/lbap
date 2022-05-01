<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\View;

class LoginController extends Controller
{
    /**
     * @return View
     */
    public function create(): View
    {
        return view('login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
