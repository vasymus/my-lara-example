<?php

namespace Domain\Orders\DTOs;

use Domain\Orders\Models\Order;
use Domain\Users\Models\BaseUser\BaseUser;
use Spatie\DataTransferObject\DataTransferObject;

class DefaultUpdateOrderParams extends DataTransferObject
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
     * @var string|int|float|null
     */
    public $comment_user;

    /**
     * @var string|int|float|null
     */
    public $comment_admin;

    /**
     * @var int|string|null
     */
    public $payment_method_id;

    /**
     * @var int|string|null
     */
    public $admin_id;

    /**
     * @var int|string|null
     */
    public $importance_id;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $email;

    /**
     * @var string|null
     */
    public ?string $phone;
}
