<?php

namespace App\Policies;

use Domain\Users\Models\BaseUser\BaseUser;

class MediaPolicy extends BasePolicy
{
    public function show(BaseUser $authUser, BaseUser $user): bool
    {
        return (string)$authUser->id === (string)$user->id;
    }
}
