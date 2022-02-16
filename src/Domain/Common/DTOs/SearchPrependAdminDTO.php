<?php

namespace Domain\Common\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class SearchPrependAdminDTO extends DataTransferObject
{
    /**
     * @var string|int|float
     */
    public $label;

    public string $onClear;
}
