<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\BaseUser\BaseUser;

class ChangeOrderProductsAction
{
    /**
     * @param \Domain\Orders\Models\Order $order
     * @param \Domain\Users\Models\BaseUser\BaseUser $user
     * @param array[] $productItems @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO}
     *
     * @return void
     */
    public function execute(Order $order, BaseUser $user, array $productItems): void
    {
        $orderEvents = [];

        $productsPrepare = [];

        /** @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO} */
        foreach ($productItems as $productItem) {
            $prepared = [
                'count' => $productItem['order_product_count'],
                'name' => $productItem['name'],
                'unit' => $productItem['unit'],
                'price_retail_rub' => $productItem['order_product_price_retail_rub'],
                'price_retail_rub_was_updated' => $productItem['order_product_price_retail_rub_was_updated'],
                'ordering' => $productItem['ordering'],
            ];
            /** @var \Domain\Products\Models\Product\Product|null $currentOrderProduct */
            $currentOrderProduct = $order->products->first(fn (Product $product) => (string)$product->id === (string)$productItem['id']);
            // updating
            if ($currentOrderProduct) {
                $productsPrepare[$productItem['id']] = array_merge($prepared, [
                    'price_purchase' => $currentOrderProduct->order_product->price_purchase,
                    'price_purchase_currency_id' => $currentOrderProduct->order_product->price_purchase_currency_id,
                    'price_retail' => $currentOrderProduct->order_product->price_retail,
                    'price_retail_currency_id' => $currentOrderProduct->order_product->price_retail_currency_id,
                    'price_retail_rub_origin' => $currentOrderProduct->order_product->price_retail_rub_origin,
                ]);

                if ($currentOrderProduct->order_product->name !== $productItem['name']) {
                    $orderEvents[] = $this->makeChangeProductItemNameOrderEvent($currentOrderProduct->id, $productItem['name']);
                }
                if ($currentOrderProduct->order_product->unit !== $productItem['unit']) {
                    $orderEvents[] = $this->makeChangeProductItemUnitOrderEvent($currentOrderProduct->id, $productItem['unit']);
                }
                if ($currentOrderProduct->order_product->count !== $productItem['order_product_count']) {
                    $orderEvents[] = $this->makeChangeProductItemQuantityOrderEvent($currentOrderProduct->id, $productItem['order_product_count']);
                }
                if (floor($currentOrderProduct->order_product->price_retail_rub * 100) !== floor($productItem['order_product_price_retail_rub'] * 100)) {
                    $orderEvents[] = $this->makeChangeProductItemPriceOrderEvent($currentOrderProduct->id, $productItem['order_product_price_retail_rub']);
                }

                continue;
            }

            // creating
            $currentProduct = Product::query()->findOrFail($productItem['id']);
            $productsPrepare[$productItem['id']] = array_merge($prepared, [
                'price_purchase' => $currentProduct->price_purchase,
                'price_purchase_currency_id' => $currentProduct->price_purchase_currency_id,
                'price_retail' => $currentProduct->price_retail,
                'price_retail_currency_id' => $currentProduct->price_retail_currency_id,
                'price_retail_rub_origin' => $currentProduct->price_retail_rub,
            ]);
            $orderEvents[] = $this->makeAddProductItemOrderEvent($currentProduct, $productItem['order_product_count']);
        }

        $currentProductItemsIds = $order->products->pluck('id')->values()->toArray();
        $syncProductItemsIds = collect($productsPrepare)->keys()->values()->toArray();
        $deleteIds = array_diff($currentProductItemsIds, $syncProductItemsIds);

        $order->products()->sync($productsPrepare);

        foreach ($deleteIds as $deleteId) {
            $orderEvents[] = $this->makeDeleteProductItemOrderEvent($deleteId);
        }

        foreach ($orderEvents as $orderEvent) {
            $this->createOrderEvent($orderEvent, $order, $user);
        }
    }

    /**
     * @param int $productItemId
     * @param int $newCount
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeChangeProductItemQuantityOrderEvent(int $productItemId, $newCount): OrderEvent
    {
        $product = Product::query()->withTrashed()->findOrFail($productItemId);
        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::update_product_count();
        $orderEvent->payload = [
            'description' => sprintf('Количество товара `%s` (#%s) изменено на `%s`.', $product->name, $product->id, $newCount),
            'product_id' => $product->id,
            'product_uuid' => $product->uuid,
            'count' => $newCount,
        ];

        return $orderEvent;
    }

    /**
     * @param int $productItemId
     * @param string|float $newPrice
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeChangeProductItemPriceOrderEvent(int $productItemId, $newPrice): OrderEvent
    {
        $product = Product::query()->withTrashed()->findOrFail($productItemId);
        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::update_product_price_retail();
        $orderEvent->payload = [
            'description' => sprintf('Цена товара `%s` (#%s) изменена на `%s`.', $product->name, $product->id, $newPrice),
            'product_id' => $product->id,
            'product_uuid' => $product->uuid,
            'price_retail' => $newPrice,
        ];

        return $orderEvent;
    }

    /**
     * @param int $productItemId
     * @param string $newName
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeChangeProductItemNameOrderEvent(int $productItemId, string $newName): OrderEvent
    {
        $product = Product::query()->withTrashed()->findOrFail($productItemId);
        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::update_product_name();
        $orderEvent->payload = [
            'description' => sprintf('Название товара `%s` (#%s) изменено на `%s`.', $product->name, $product->id, $newName),
            'product_id' => $product->id,
            'product_uuid' => $product->uuid,
            'name' => $newName,
        ];

        return $orderEvent;
    }

    /**
     * @param int $productItemId
     * @param string $newUnit
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeChangeProductItemUnitOrderEvent(int $productItemId, string $newUnit): OrderEvent
    {
        $product = Product::query()->withTrashed()->findOrFail($productItemId);
        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::update_product_name();
        $orderEvent->payload = [
            'description' => sprintf('Упаковка / единица измерения товара `%s` (#%s) изменена на `%s`.', $product->name, $product->id, $newUnit),
            'product_id' => $product->id,
            'product_uuid' => $product->uuid,
            'unit' => $newUnit,
        ];

        return $orderEvent;
    }

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param int $count
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeAddProductItemOrderEvent(Product $product, int $count = 1): OrderEvent
    {
        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::add_product();
        $orderEvent->payload = [
            'description' => sprintf('Добавлен товар `%s` (#%s) в количестве %s.', $product->name, $product->id, $count),
            'product_id' => $product->id,
            'product_uuid' => $product->uuid,
        ];

        return $orderEvent;
    }

    /**
     * @param int $deletedProductItemId
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeDeleteProductItemOrderEvent(int $deletedProductItemId): OrderEvent
    {
        $product = Product::query()->withTrashed()->findOrFail($deletedProductItemId);
        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::delete_product();
        $orderEvent->payload = [
            'description' => sprintf('Удалён товар `%s` (#%s).', $product->name, $product->id),
            'product_id' => $product->id,
            'product_uuid' => $product->uuid,
        ];

        return $orderEvent;
    }

    /**
     * @param \Domain\Orders\Models\OrderEvent $orderEvent
     * @param \Domain\Orders\Models\Order $order
     * @param \Domain\Users\Models\BaseUser\BaseUser|null $user
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function createOrderEvent(OrderEvent $orderEvent, Order $order, BaseUser $user = null): OrderEvent
    {
        $orderEvent->order()->associate($order);
        if ($user) {
            $orderEvent->user()->associate($user);
        }
        $orderEvent->save();

        return $orderEvent;
    }
}
