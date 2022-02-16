<?php

namespace App\Policies;

use Domain\Users\Models\BaseUser\BaseUser;

class AdminProfilePolicy extends BasePolicy
{
    public function update(BaseUser $authUser, BaseUser $user): bool
    {
        return (string)$authUser->id === (string)$user->id;
    }
}
