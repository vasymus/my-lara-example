<?php

namespace Tests\Feature\Domain\Users\Actions;

use Domain\Products\Models\Product\Product;
use Domain\Users\Actions\TransferProductsAction;
use Domain\Users\Models\User\User;
use Tests\Feature\BaseActionTestCase;

class TransferProductsActionTest extends BaseActionTestCase
{
    public function testProductsTransferredSuccessfully()
    {
        $product = Product::factory()->create();

        /** @var \Domain\Users\Models\BaseUser\BaseUser $fromUser */
        $fromUser = User::factory()
            ->hasAttached(
                $product,
                [
                    'count' => random_int(1, 5),
                    'created_at' => now(),
                ],
                'cart'
            )
            ->create();
        /** @var \Domain\Users\Models\BaseUser\BaseUser $toUser */
        $toUser = User::factory()->create();

        TransferProductsAction::cached()->execute($fromUser, $toUser);

        $this->assertTrue($toUser->cart_not_trashed->isNotEmpty());
    }
}
