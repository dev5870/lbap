<?php

namespace App\Http\Controllers;

use App\Http\Filters\LogFilter;
use App\Http\Filters\UserFilter;
use App\Models\User;
use App\Models\UserUserAgent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $filter = new UserFilter($request);

        return view('admin.user.index', [
            'users' => User::sortable(['id' => 'desc'])->with('roles')->filter($filter)->paginate(config('view.per_page')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.user.edit', [
            'logs' => UserUserAgent::where('user_id', '=', $user->id)->sortable(['created_at' => 'desc'])->paginate(config('view.per_page')),
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param Request $request
     * @return View
     */
    public function log(Request $request): View
    {
        $filter = new LogFilter($request);

        return view('admin.user.log.index', [
            'logs' => UserUserAgent::sortable(['created_at' => 'desc'])->filter($filter)->paginate(config('view.per_page')),
        ]);
    }
}
