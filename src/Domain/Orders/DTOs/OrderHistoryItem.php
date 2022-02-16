<?php

namespace Domain\Orders\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class OrderHistoryItem extends DataTransferObject
{
    public int $orderEventId;

    public ?string $userName;

    public string $operation;

    public string $description;

    public ?string $date;
}
