<?php

namespace Domain\Products\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self ordering()
 * @method static self name()
 * @method static self active()
 * @method static self unit()
 * @method static self price_purchase()
 * @method static self price_retail()
 * @method static self admin_comment()
 * @method static self availability()
 * @method static self id()
 */
class ProductAdminColumn extends Enum
{
    /**
     * @return string[]|int[]
     */
    protected static function values()
    {
        return [
            'ordering' => 1,
            'name' => 2,
            'active' => 3,
            'unit' => 4,
            'price_purchase' => 5,
            'price_retail' => 6,
            'admin_comment' => 7,
            'availability' => 8,
            'id' => 9,
        ];
    }

    /**
     * @return string[]
     */
    protected static function labels()
    {
        return [
            'ordering' => 'Сортировка',
            'name' => 'Название',
            'active' => 'Актив.',
            'unit' => 'Упаковка',
            'price_purchase' => 'Закупочная',
            'price_retail' => 'Розничная',
            'admin_comment' => 'Служебная Информация',
            'availability' => 'Наличие',
            'id' => 'ID',
        ];
    }
}
