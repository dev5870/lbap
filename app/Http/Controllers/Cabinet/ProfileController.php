<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\ProfileUpdateRequest;
use App\Models\UserParam;
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
            'profile' => $profile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request, UserParam $profile)
    {
        if (!$profile->update($request->validated())) {
            return redirect()->route('cabinet.profile.edit', $profile)->with([
                'error-message' => __('title.error')
            ]);
        }

        return redirect()->route('cabinet.profile.edit', $profile)->with([
            'success-message' => __('title.success')
        ]);
    }
}
