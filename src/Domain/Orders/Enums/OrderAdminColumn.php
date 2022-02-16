<?php

namespace Domain\Orders\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self date()
 * @method static self id()
 * @method static self status()
 * @method static self positions()
 * @method static self comment_admin()
 * @method static self importance()
 * @method static self manager()
 * @method static self sum()
 * @method static self name()
 * @method static self phone()
 * @method static self email()
 * @method static self comment_user()
 * @method static self payment_method()
 */
class OrderAdminColumn extends Enum
{
    /**
     * @return string[]|int[]
     */
    protected static function values()
    {
        return [
            'date' => 1,
            'id' => 2,
            'status' => 3,
            'positions' => 4,
            'comment_admin' => 5,
            'importance' => 6,
            'manager' => 7,
            'sum' => 8,
            'name' => 9,
            'phone' => 10,
            'email' => 11,
            'comment_user' => 12,
            'payment_method' => 13,
        ];
    }

    /**
     * @return string[]
     */
    protected static function labels()
    {
        return [
            'date' => 'Дата создания',
            'id' => 'ID',
            'status' => 'Статус',
            'positions' => 'Позиции',
            'comment_admin' => 'Комментарии',
            'importance' => 'Важность',
            'manager' => 'Менеджер',
            'sum' => 'Сумма',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Email',
            'comment_user' => 'Комментарий покупателя',
            'payment_method' => 'Платежная система',
        ];
    }
}
