<?php

namespace App\Http\Controllers;

use App\Http\Filters\LogFilter;
use App\Http\Filters\UserFilter;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserReferral;
use App\Models\UserUserAgent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filter = new UserFilter($request);

        return view('admin.user.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'users' => User::sortable(['id' => 'desc'])->with('roles')->filter($filter)->paginate(config('view.per_page')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.user.edit', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'logs' => UserUserAgent::where('user_id', '=', $user->id)->sortable(['created_at' => 'desc'])->paginate(config('view.per_page')),
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->status = $request->get('status');
        $user->telegram = $request->get('telegram');
        $user->roles()->sync($request->get('roles'));
        $user->save();

        return redirect()->route('admin.user.edit', $user)->with([
            'success-message' => __('title.success')
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function log(Request $request): View
    {
        $filter = new LogFilter($request);

        return view('admin.user.log.index', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'logs' => UserUserAgent::sortable(['created_at' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.user.create', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegistrationRequest $request
     * @return RedirectResponse
     */
    public function store(RegistrationRequest $request): RedirectResponse
    {
        $user = User::create([
            'referrer' => $request->get('referrer'),
            'email' => $request->get('email'),
            'telegram' => $request->get('telegram'),
            'password' => Hash::make($request->get('password'))
        ]);

        if ($user->referrer) {
            UserReferral::create([
                'user_id' => $user->referrer,
                'referral_id' => $user->id,
            ]);
        }

        if ($user) {
            return redirect()->route('admin.user.index')->with([
                'success-message' => __('title.registration.success')
            ]);
        }

        return redirect()->route('admin.user.create')->with([
            'error-message' => __('title.registration.error')
        ]);
    }
}
