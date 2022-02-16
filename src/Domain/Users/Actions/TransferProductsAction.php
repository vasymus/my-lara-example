<?php

namespace Domain\Users\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\BaseUser\BaseUser;

/**
 * @link \Tests\Feature\Domain\Users\Actions\TransferProductsActionTest
 */
class TransferProductsAction extends BaseAction
{
    /**
     * @param \Domain\Users\Models\BaseUser\BaseUser $from
     * @param \Domain\Users\Models\BaseUser\BaseUser $to
     *
     * @return void
     */
    public function execute(BaseUser $from, BaseUser $to)
    {
        $viewedPrepared = [];
        $from->viewed->each(function (Product $product) use (&$viewedPrepared) {
            $viewedPrepared[$product->id] = [
                "created_at" => $product->viewed_product->created_at ?? null,
                "updated_at" => $product->viewed_product->updated_at ?? null,
            ];
        });
        $to->viewed()->sync($viewedPrepared);

        $cartPrepared = [];
        $from->cart_not_trashed->each(function (Product $product) use (&$cartPrepared) {
            $cartPrepared[$product->id] = [
                "created_at" => $product->cart_product->created_at ?? null,
                "updated_at" => $product->cart_product->updated_at ?? null,
                "deleted_at" => $product->cart_product->deleted_at ?? null,
            ];
        });
        $to->cart()->sync($cartPrepared);

        $asidePrepared = [];
        $from->aside->each(function (Product $product) use (&$asidePrepared) {
            $asidePrepared[$product->id] = [
                "created_at" => $product->aside_product->created_at ?? null,
                "updated_at" => $product->aside_product->updated_at ?? null,
            ];
        });
        $to->aside()->sync($asidePrepared);
    }
}
