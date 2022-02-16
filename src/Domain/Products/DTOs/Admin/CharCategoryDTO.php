<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;
use Spatie\DataTransferObject\DataTransferObject;

class CharCategoryDTO extends DataTransferObject
{
    public ?int $id;

    public string $name;

    public int $ordering = CharCategory::DEFAULT_ORDERING;

    /**
     * @var \Domain\Products\DTOs\Admin\CharDTO[]
     */
    public array $chars = [];

    public static function fromModel(CharCategory $charCategory): self
    {
        $initOrdering = Char::DEFAULT_ORDERING;

        $chars = $charCategory->chars
            ->map(function (Char $char) use (&$initOrdering) {
                if ($initOrdering >= $char->ordering) {
                    $char->ordering = $initOrdering = $initOrdering + 100;
                }

                return CharDTO::fromModel($char);
            })
            ->sortBy('ordering')
            ->values()
            ->all();

        return new self([
            'id' => $charCategory->id,
            'name' => $charCategory->name,
            'ordering' => $charCategory->ordering ?? CharCategory::DEFAULT_ORDERING,
            'chars' => $chars,
        ]);
    }
}
