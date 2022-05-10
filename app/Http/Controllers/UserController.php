<?php

namespace App\Http\Controllers;

use App\Http\Filters\LogFilter;
use App\Http\Filters\UserFilter;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserUserAgent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
}
