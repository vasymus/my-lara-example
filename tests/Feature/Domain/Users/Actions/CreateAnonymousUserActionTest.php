<?php

namespace Tests\Feature\Domain\Users\Actions;

use Domain\Users\Actions\CreateAnonymousUserAction;
use Tests\Feature\BaseActionTestCase;

class CreateAnonymousUserActionTest extends BaseActionTestCase
{
    public function testAnonymousUserCreatedSuccessfully()
    {
        $user = CreateAnonymousUserAction::cached()->execute();
        $this->assertNotEmpty($user);
    }
}
