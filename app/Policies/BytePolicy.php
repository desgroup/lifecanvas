<?php

namespace App\Policies;

use App\Byte;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BytePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether a user can update the byte.
     *
     * @param User $user
     * @param Byte $byte
     * @return bool
     */
    public function update(User $user, Byte $byte)
    {
        return $byte->user_id == $user->id;
    }
}
