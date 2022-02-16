<?php

namespace Domain\Orders\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Orders\Enums\OrderAdminColumn;

class GetDefaultAdminOrderColumnsAction extends BaseAction
{
    /**
     * @return \Domain\Orders\Enums\OrderAdminColumn[]
     */
    public function execute(): array
    {
        return [
            OrderAdminColumn::date(),
            OrderAdminColumn::id(),
            OrderAdminColumn::status(),
            OrderAdminColumn::positions(),
            OrderAdminColumn::comment_admin(),
            OrderAdminColumn::importance(),
            OrderAdminColumn::manager(),
            OrderAdminColumn::sum(),
            OrderAdminColumn::name(),
            OrderAdminColumn::phone(),
            OrderAdminColumn::email(),
            OrderAdminColumn::comment_user(),
            OrderAdminColumn::payment_method(),
        ];
    }
}
