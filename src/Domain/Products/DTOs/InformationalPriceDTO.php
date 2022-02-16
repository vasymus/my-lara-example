<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\InformationalPrice;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class InformationalPriceDTO extends DataTransferObject
{
    public ?int $id;

    public ?int $product_id;

    public ?string $name;

    /**
     * @var float|int|string|null
     */
    public $price;

    public string $temp_uuid;

    public static function fromModel(InformationalPrice $infoPrice): self
    {
        return new self([
            'id' => $infoPrice->id,
            'product_id' => $infoPrice->product_id,
            'name' => $infoPrice->name,
            'price' => $infoPrice->price,
            'temp_uuid' => Str::uuid()->toString(),
        ]);
    }

    public static function copyFromModel(InformationalPrice $infoPrice): self
    {
        return new self([
            'product_id' => $infoPrice->product_id,
            'name' => $infoPrice->name,
            'price' => $infoPrice->price,
            'temp_uuid' => Str::uuid()->toString(),
        ]);
    }

    public static function create(array $params = []): self
    {
        return new self(array_merge(
            [
                'temp_uuid' => Str::uuid()->toString(),
            ],
            $params
        ));
    }
}
