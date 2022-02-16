<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Char;
use Spatie\DataTransferObject\DataTransferObject;

class CharDTO extends DataTransferObject
{
    public ?int $id;

    public string $name;

    public int $type_id;

    public int $ordering = Char::DEFAULT_ORDERING;

    public bool $is_rate;

    /**
     * @var string|int|float|null
     */
    public $value;

    public static function fromModel(Char $char): self
    {
        return new self([
            'id' => $char->id,
            'name' => $char->name,
            'type_id' => $char->type_id,
            'ordering' => $char->ordering ?? Char::DEFAULT_ORDERING,
            'is_rate' => $char->is_rate,
            'value' => $char->is_rate ? (int)$char->value : $char->value,
        ]);
    }
}
