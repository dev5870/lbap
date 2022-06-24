<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\UserParam;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserParam $profile): View
    {
        return view('cabinet.user.profile', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'profile' => $profile,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserParam $profile): View
    {
        return view('cabinet.user.edit', [
            'notifications' => Notification::all(),
            'settings' => Setting::first(),
            'profile' => $profile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserParam $profile)
    {
        //
    }
}
