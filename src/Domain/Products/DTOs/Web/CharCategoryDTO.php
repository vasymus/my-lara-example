<?php

namespace Domain\Products\DTOs\Web;

use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;
use Spatie\DataTransferObject\DataTransferObject;

class CharCategoryDTO extends DataTransferObject
{
    public int $id;

    public string $name;

    public int $ordering;

    /**
     * @var \Domain\Products\DTOs\Web\CharDTO[]
     */
    public array $chars = [];

    public static function fromModel(CharCategory $charCategory): self
    {
        return new self([
            'id' => $charCategory->id,
            'name' => $charCategory->name,
            'ordering' => $charCategory->ordering,
            'chars' => $charCategory->chars->map(fn (Char $char) => CharDTO::fromModel($char))->all(),
        ]);
    }
}
