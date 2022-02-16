<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Orders\Models\Order;
use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class OrderItemDTO extends DataTransferObject
{
    public int $id;

    /**
     * @var string|null Format 'd-m-Y H:i:s'
     */
    public ?string $date;

    public int $order_status_id;

    public string $order_status_name;

    public ?string $order_status_color;

    public ?string $comment_admin;

    public ?string $comment_user;

    public ?int $importance_id;

    public ?string $importance_name;

    public ?string $importance_color;

    public ?int $admin_id;

    public ?string $admin_name;

    public ?string $admin_color;

    public ?int $user_id;

    public ?string $user_name;

    public ?string $user_email;

    public ?string $user_phone;

    public string $order_price_retail_rub_formatted;

    /**
     * @var \Domain\Products\DTOs\Admin\OrderItemProductItemDTO[]
     */
    public array $products;

    public ?int $payment_method_id;

    public ?string $payment_method_name;

    public bool $is_busy_by_other_admin = false;

    public static function fromModel(Order $order): self
    {
        return new static([
            'id' => $order->id,
            'date' => $order->date_formatted,
            'order_status_id' => $order->order_status_id,
            'order_status_name' => $order->status->name ?? "",
            'order_status_color' => $order->status->color ?? null,
            'comment_admin' => $order->comment_admin,
            'comment_user' => $order->comment_user,
            'importance_id' => $order->importance_id,
            'importance_name' => $order->importance->name ?? null,
            'importance_color' => $order->importance->color ?? null,
            'admin_id' => $order->admin_id,
            'admin_name' => $order->admin->name ?? null,
            'admin_color' => $order->admin->admin_color ?? null,
            'user_id' => $order->user_id ?? null,
            'user_name' => $order->user->name ?? null,
            'user_email' => $order->user->email ?? null,
            'user_phone' => $order->user->phone ?? null,
            'order_price_retail_rub_formatted' => $order->order_price_retail_rub_formatted,
            'products' => $order->products->map(fn (Product $product) => OrderItemProductItemDTO::fromModel($product))->all(),
            'payment_method_id' => $order->payment_method_id,
            'payment_method_name' => $order->payment->name ?? null,
            'is_busy_by_other_admin' => $order->is_busy_by_other_admin,
        ]);
    }
}
