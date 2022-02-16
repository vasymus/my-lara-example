<?php

namespace Domain\Users\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Users\Models\User\User;

/**
 * @link \Tests\Feature\Domain\Users\Actions\CreateAnonymousUserActionTest
 */
class CreateAnonymousUserAction extends BaseAction
{
    /**
     * @return \Domain\Users\Models\User\User
     */
    public function execute(): User
    {
        $user = User::create();

        /** @var \Domain\Users\Models\User\User $result */
        $result = User::query()->findOrFail($user->id); // @phpstan-ignore-line

        return $result;
    }
}
