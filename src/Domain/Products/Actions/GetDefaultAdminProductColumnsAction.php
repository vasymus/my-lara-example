<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Enums\ProductAdminColumn;

class GetDefaultAdminProductColumnsAction extends BaseAction
{
    /**
     * @return \Domain\Products\Enums\ProductAdminColumn[]
     */
    public function execute(): array
    {
        return [
            ProductAdminColumn::ordering(),
            ProductAdminColumn::name(),
            ProductAdminColumn::active(),
            ProductAdminColumn::unit(),
            ProductAdminColumn::price_purchase(),
            ProductAdminColumn::price_retail(),
            ProductAdminColumn::admin_comment(),
            ProductAdminColumn::availability(),
            ProductAdminColumn::id(),
        ];
    }
}
