<?php

namespace Domain\Orders\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self checkout()
 * @method static self admin_created()
 * @method static self update_status()
 * @method static self update_comment_admin()
 * @method static self update_payment_method()
 * @method static self update_comment_user()
 * @method static self update_admin()
 * @method static self update_importance()
 * @method static self update_customer_personal_data()
 * @method static self update_customer_invoice()
 * @method static self update_supplier_invoice()
 * @method static self add_product()
 * @method static self update_product_name()
 * @method static self update_product_price_retail()
 * @method static self update_product_count()
 * @method static self update_product_unit()
 * @method static self delete_product()
 * @method static self cancellation()
 * @method static self delete()
 */
class OrderEventType extends Enum
{
    /**
     * @return string[]|int[]
     */
    protected static function values()
    {
        return [
            'checkout' => 1,
            'admin_created' => 2,
            'update_status' => 3,
            'update_comment_admin' => 4,
            'update_payment_method' => 5,
            'update_comment_user' => 6,
            'update_admin' => 7,
            'update_importance' => 8,
            'update_customer_personal_data' => 9,
            'update_customer_invoice' => 10,
            'update_supplier_invoice' => 11,
            'add_product' => 12,
            'update_product_name' => 13,
            'update_product_price_retail' => 14,
            'update_product_count' => 15,
            'update_product_unit' => 16,
            'delete_product' => 17,
            'cancellation' => 18,
            'delete' => 19,
        ];
    }
}
