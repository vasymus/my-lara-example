<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DTOs\DefaultUpdateOrderParams;
use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\PaymentMethod;
use Domain\Users\Models\Admin;
use Domain\Users\Models\BaseUser\BaseUser;

class DefaultUpdateOrderAction
{
    /**
     * @param \Domain\Orders\DTOs\DefaultUpdateOrderParams $params
     *
     * @return void
     */
    public function execute(DefaultUpdateOrderParams $params): void
    {
        $orderEvents = [];

        if ((string)$params->order->getOriginal('comment_user') !== (string)$params->comment_user) {
            $params->order->comment_user = $params->comment_user;
            $orderEvents[] = $this->makeCommentUserOrderEvent($params);
        }

        if ((string)$params->order->getOriginal('comment_admin') !== (string)$params->comment_admin) {
            $params->order->comment_admin = $params->comment_admin;
            $orderEvents[] = $this->makeCommentAdminOrderEvent($params);
        }

        if ((string)$params->order->getOriginal('payment_method_id') !== (string)$params->payment_method_id) {
            $params->order->payment_method_id = $params->payment_method_id;
            $orderEvents[] = $this->makePaymentMethodOrderEvent($params);
        }

        if ((string)$params->order->getOriginal('admin_id') !== (string)$params->admin_id) {
            $params->order->admin_id = $params->admin_id;
            $orderEvents[] = $this->makeAdminOrderEvent($params);
        }

        if ((string)$params->order->getOriginal('importance_id') !== (string)$params->importance_id) {
            $params->order->importance_id = $params->importance_id;
            $orderEvents[] = $this->makeImportanceOrderEvent($params);
        }

        $request = $params->order->getOriginal('request');
        $request = is_array($request) ? $request : [];
        $name = $request['name'] ?? null;
        $email = $request['email'] ?? null;
        $phone = $request['phone'] ?? null;

        if (
            ! empty(
                array_diff(
                    [$name, $email, $phone],
                    [$params->name, $params->email, $params->phone]
                )
            )
        ) {
            $request = $params->order->request;
            $request['name'] = $params->name;
            $request['email'] = $params->email;
            $request['phone'] = $params->phone;
            $params->order->request = $request;
            $orderEvents[] = $this->makeCustomerPersonalDataOrderEvent($params);
        }

        $params->order->save();
        foreach ($orderEvents as $orderEvent) {
            $this->createOrderEvent($orderEvent, $params->order, $params->user);
        }
    }

    /**
     * @param \Domain\Orders\DTOs\DefaultUpdateOrderParams $params
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeCommentUserOrderEvent(DefaultUpdateOrderParams $params): OrderEvent
    {
        $orderEvent = new OrderEvent();
        $orderEvent->payload = [
            'description' => $params->comment_user,
        ];
        $orderEvent->type = OrderEventType::update_comment_user();

        return $orderEvent;
    }

    /**
     * @param \Domain\Orders\DTOs\DefaultUpdateOrderParams $params
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeCommentAdminOrderEvent(DefaultUpdateOrderParams $params): OrderEvent
    {
        $orderEvent = new OrderEvent();
        $orderEvent->payload = [
            'description' => $params->comment_admin,
        ];
        $orderEvent->type = OrderEventType::update_comment_admin();

        return $orderEvent;
    }

    /**
     * @param \Domain\Orders\DTOs\DefaultUpdateOrderParams $params
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makePaymentMethodOrderEvent(DefaultUpdateOrderParams $params): OrderEvent
    {
        $orderEvent = new OrderEvent();
        $paymentMethod = PaymentMethod::query()->findOrFail($params->payment_method_id);
        $orderEvent->payload = [
            'description' => sprintf('Способ оплаты изменён на "%s"', $paymentMethod->name),
        ];
        $orderEvent->type = OrderEventType::update_payment_method();

        return $orderEvent;
    }

    /**
     * @param \Domain\Orders\DTOs\DefaultUpdateOrderParams $params
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeAdminOrderEvent(DefaultUpdateOrderParams $params): OrderEvent
    {
        $orderEvent = new OrderEvent();
        $admin = Admin::query()->findOrFail($params->admin_id);
        $orderEvent->payload = [
            'description' => $admin->name,
        ];
        $orderEvent->type = OrderEventType::update_admin();

        return $orderEvent;
    }

    /**
     * @param \Domain\Orders\DTOs\DefaultUpdateOrderParams $params
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeImportanceOrderEvent(DefaultUpdateOrderParams $params): OrderEvent
    {
        $orderEvent = new OrderEvent();
        $orderImportance = OrderImportance::query()->findOrFail($params->importance_id);
        $orderEvent->payload = [
            'description' => $orderImportance->name,
        ];
        $orderEvent->type = OrderEventType::update_importance();

        return $orderEvent;
    }

    /**
     * @param \Domain\Orders\DTOs\DefaultUpdateOrderParams $params
     *
     * @return \Domain\Orders\Models\OrderEvent
     */
    private function makeCustomerPersonalDataOrderEvent(DefaultUpdateOrderParams $params): OrderEvent
    {
        $request = $params->order->getOriginal('request');
        $request = is_array($request) ? $request : [];
        $name = $request['name'] ?? null;
        $email = $request['email'] ?? null;
        $phone = $request['phone'] ?? null;

        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::update_customer_personal_data();
        $description = "";
        if ($name !== $params->name) {
            $description .= sprintf('Имя: "%s"', $params->name);
        }
        if ($email !== $params->email) {
            $description .= sprintf('Е-мейл: "%s"', $params->email);
        }
        if ($phone !== $params->phone) {
            $description .= sprintf('Телефон: "%s"', $params->phone);
        }
        $orderEvent->payload = [
            'description' => $description,
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
