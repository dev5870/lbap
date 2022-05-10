<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    /**
     * @return View
     */
    public function create(): View
    {
        return view('registration');
    }

    /**
     * @return RedirectResponse
     */
    public function store(RegistrationRequest $request): RedirectResponse
    {
        $user = User::create([
            'email' => $request->get('email'),
            'telegram' => $request->get('telegram'),
            'password' => Hash::make($request->get('password'))
        ]);

        if ($user) {
            return redirect()->route('admin.dashboard')->with([
                'success-message' => __('title.registration.success')
            ]);
        }

        return redirect()->route('registration.create')->with([
            'error-message' => __('title.registration.error')
        ]);
    }
}
