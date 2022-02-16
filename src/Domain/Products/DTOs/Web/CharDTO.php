<?php

namespace Domain\Products\DTOs\Web;

use Domain\Products\Actions\GetCharHtmlAction;
use Domain\Products\Models\Char;
use Spatie\DataTransferObject\DataTransferObject;

class CharDTO extends DataTransferObject
{
    public int $id;

    public string $name;

    /**
     * @var \Illuminate\Support\HtmlString|null
     */
    public $html;

    /**
     * @var string|int|float|null
     */
    public $value;

    public int $category_id;

    public bool $is_empty;

    public static function fromModel(Char $char): self
    {
        return new self([
            'id' => $char->id,
            'name' => $char->name,
            'html' => GetCharHtmlAction::cached()->execute($char),
            'value' => $char->value,
            'category_id' => $char->category_id,
            'is_empty' => $char->is_empty,
        ]);
    }
}
