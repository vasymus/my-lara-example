<?php

namespace Domain\Orders\DTOs;

use Domain\Orders\Models\Order;
use Domain\Users\Models\BaseUser\BaseUser;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateOrderInvoicesParamsDTO extends DataTransferObject
{
    /**
     * @var \Domain\Orders\Models\Order
     */
    public Order $order;

    /**
     * @var \Domain\Users\Models\BaseUser\BaseUser|null
     */
    public ?BaseUser $user;

    /**
     * @var int|string|null
     */
    public $customer_bill_status_id;

    /**
     * @var string|null
     */
    public ?string $customer_bill_description;

    /**
     * @var int|string|null
     */
    public $provider_bill_status_id;

    /**
     * @var string|null
     */
    public ?string $provider_bill_description;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $customerInvoices = [];

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $supplierInvoices = [];
}
