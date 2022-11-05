<?php
declare(strict_types=1);

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\ProfileUpdateRequest;
use App\Models\UserParam;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * @param UserParam $profile
     * @return View
     */
    public function show(UserParam $profile): View
    {
        return view('cabinet.user.profile', [
            'profile' => $profile,
        ]);
    }

    /**
     * @param UserParam $profile
     * @return View
     */
    public function edit(UserParam $profile): View
    {
        return view('cabinet.user.edit', [
            'profile' => $profile,
        ]);
    }

    /**
     * @param ProfileUpdateRequest $request
     * @param UserParam $profile
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request, UserParam $profile): RedirectResponse
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
