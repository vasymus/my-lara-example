<?php

namespace Domain\Common\DTOs;

use Domain\Common\Models\BaseModel;
use Domain\Common\Models\Currency;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Orders\Models\PaymentMethod;
use Domain\Products\Actions\GetCharDotsHtmlStringAction;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\CharType;
use Domain\Users\Models\BaseUser\BaseUser;
use Spatie\DataTransferObject\DataTransferObject;

class OptionDTO extends DataTransferObject
{
    /**
     * @var string|int|float|bool|null
     */
    public $value;

    /**
     * @var string|\Illuminate\Support\HtmlString
     */
    public $label;

    /**
     * @var bool
     */
    public bool $disabled = false;

    /**
     * @var bool
     */
    public bool $isHtmlString = false;

    /**
     * @param \Domain\Products\Models\Brand $brand
     *
     * @return self
     */
    public static function fromBrand(Brand $brand): self
    {
        return new self([
            'value' => $brand->id,
            'label' => $brand->name,
        ]);
    }

    /**
     * @param \Domain\Common\Models\Currency $currency
     *
     * @return self
     */
    public static function fromCurrency(Currency $currency): self
    {
        return new self([
            'value' => $currency->id,
            'label' => $currency->name,
        ]);
    }

    /**
     * @param \Domain\Products\Models\AvailabilityStatus $availabilityStatus
     *
     * @return self
     */
    public static function fromAvailabilityStatus(AvailabilityStatus $availabilityStatus): self
    {
        return new self([
            'value' => $availabilityStatus->id,
            'label' => $availabilityStatus->name,
        ]);
    }

    public static function fromCategory(Category $category, int $level = 1, bool $disabled = false, bool $isHtmlString = true): self
    {
        $dot = $isHtmlString ? '<span>.</span>' : '.';
        $label = implode('', array_fill(0, $level - 1, $dot)) . $category->name;

        return new self([
            'value' => $category->id,
            'label' => $label,
            'disabled' => $disabled,
            'isHtmlString' => $isHtmlString,
        ]);
    }

    /**
     * @param string[]|int[]|float[]|bool[]|null[] $itemsArr
     *
     * @return self[]
     */
    public static function fromItemsArr(array $itemsArr): array
    {
        $result = [];

        foreach ($itemsArr as $item) {
            $result[] = new self([
                'value' => $item,
                'label' => (string)$item,
            ]);
        }

        return $result;
    }

    /**
     * @return self[]
     */
    public static function fromRateSize(): array
    {
        $result = [];

        for ($i = 0; $i < CharType::RATE_SIZE; $i++) {
            $result[] = new self([
                'value' => $i,
                'label' => GetCharDotsHtmlStringAction::cached()->execute($i),
                'isHtmlString' => true,
            ]);
        }

        return $result;
    }

    /**
     * @param \Domain\Products\Models\CharType $charType
     *
     * @return self
     */
    public static function fromCharType(CharType $charType): self
    {
        return new self([
            'value' => $charType->id,
            'label' => $charType->name,
        ]);
    }

    public static function fromAdmin(BaseUser $admin): self
    {
        return new self([
            'value' => $admin->id,
            'label' => $admin->name,
        ]);
    }

    public static function fromOrderStatus(OrderStatus $orderStatus): self
    {
        return new self([
            'value' => $orderStatus->id,
            'label' => $orderStatus->name,
        ]);
    }

    public static function fromPaymentMethod(PaymentMethod $paymentMethod): self
    {
        return new self([
            'value' => $paymentMethod->id,
            'label' => $paymentMethod->name,
        ]);
    }

    public static function fromOrderImportance(OrderImportance $orderImportance): self
    {
        return new self([
            'value' => $orderImportance->id,
            'label' => $orderImportance->name,
        ]);
    }

    public static function stdFromModel(BaseModel $model): self
    {
        return new self([
            'value' => $model->id, // @phpstan-ignore-line
            'label' => $model->name ?? "", // @phpstan-ignore-line
        ]);
    }
}
