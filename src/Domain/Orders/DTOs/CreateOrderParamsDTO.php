<?php

namespace Domain\Orders\DTOs;

use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Users\Models\BaseUser\BaseUser;
use Spatie\DataTransferObject\DataTransferObject;

class CreateOrderParamsDTO extends DataTransferObject
{
    /**
     * @var \Domain\Users\Models\BaseUser\BaseUser
     */
    public BaseUser $user;

    /**
     * @var int
     */
    public int $order_status_id = OrderStatus::ID_OPEN;

    /**
     * @var int
     */
    public int $importance_id = OrderImportance::ID_GREY;

    /**
     * @var \Domain\Orders\Enums\OrderEventType
     */
    public OrderEventType $order_event_type;

    /**
     * @var string|null
     */
    public ?string $comment_user;

    /**
     * @var string|null
     */
    public ?string $request_name;

    /**
     * @var string|null
     */
    public ?string $request_email;

    /**
     * @var string|null
     */
    public ?string $request_phone;

    /**
     * @var string[]|\Illuminate\Http\UploadedFile[]
     */
    public array $attachment = [];

    /**
     * @var \Domain\Orders\DTOs\OrderProductItemDTO[]
     */
    public array $productItems;
}
