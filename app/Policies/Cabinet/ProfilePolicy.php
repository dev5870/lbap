<?php

namespace App\Policies\Cabinet;

use App\Models\User;
use App\Models\UserParam;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param UserParam $userParam
     * @return bool
     */
    public function view(User $user, UserParam $profile): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param UserParam $profile
     * @return bool
     */
    public function update(User $user, UserParam $profile): bool
    {
        return $user->id === $profile->user_id;
    }
}
